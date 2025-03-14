<?php

namespace Modules\Wallet\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\Builders\UserBuilder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Wallet\Entities\Builders\WalletQueryBuilder;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Enums\TransactionTypeEnum;
use Modules\Wallet\Exceptions\WalletException;
use Modules\Wallet\Helpers\WalletHelper;
use Throwable;

class WalletService
{
    private Wallet $walletModel;

    private User $userModel;

    private TransactionService $transactionService;

    public function __construct(Wallet $walletModel, User $userModel, TransactionService $transactionService)
    {
        $this->walletModel = $walletModel;
        $this->userModel = $userModel;
        $this->transactionService = $transactionService;
    }

    private function baseShow($userId = null)
    {
        $userId = $userId ?: auth()->id();
        $user = WalletHelper::getUser($userId, $this->userModel);

        return $this->walletModel::query()->when(true, fn (WalletQueryBuilder $b) => $b->whereShowable($user))->firstOrFail();
    }

    public function show($userId = null)
    {
        return $this->baseShow($userId);
    }

    public function reset(array $data, $userId)
    {
        $wallet = $this->baseShow($userId);
        $incoming = $data['incoming'];
        $total = 0;

        if ($incoming) {
            $wallet->loadSum('incomingTransactions', 'amount');
            $total = (float) $wallet->incomingTransactions_sum_amount;
        } else {
            $wallet->loadSum('outgoingTransactions', 'amount');
            $total = (float) $wallet->outgoingTransactions_sum_amount;
        }

        if (! $total) {
            return;
        }

        DB::transaction(function () {
            //            $wallet->forceFill([
            //                'balance' =>
            //            ]);
        });
    }

    public function deposit(...$args): void
    {
        $this->depositOrWithdrawal(true, ...$args);
    }

    public function withdrawal(...$args): void
    {
        $this->depositOrWithdrawal(false, ...$args);
    }

    /**
     * @throws Throwable
     */
    public function transferFromAdmin(
        $toUser,
        $amount,
        $description = null,
    ): void {
        $this->transfer(
            $this->userModel::query()->whereIsAdmin()->first(),
            $toUser,
            $amount,
            $description,
        );
    }

    /**
     * @throws Throwable
     */
    public function transferToAdmin(
        $fromUser,
        $amount,
        $description = null,
    ): void {
        $this->transfer(
            $fromUser,
            $this->userModel::query()->whereIsAdmin()->first(),
            $amount,
            $description,
        );
    }

    /**
     * @throws Throwable
     */
    public function transfer(
        mixed $fromUser,
        mixed $toUser,
        $amount,
        $description = null,
    ): void {
        DB::transaction(function () use ($fromUser, $toUser, $amount, $description) {
            [$fromUserObject, $toUserObject] = $this->getValidUsers($fromUser, $toUser);

            $fromUserWallet = WalletHelper::getUserWallet($fromUserObject, $this->userModel);
            $toUserWallet = WalletHelper::getUserWallet($toUserObject, $this->userModel);

            $this->throwHasNotEnoughBalanceException($amount, $fromUserWallet);

            $fromUserWallet->decrement('balance', $amount);
            $this->transactionService->createOutGoingTransaction(
                TransactionTypeEnum::TRANSFER,
                $amount,
                $fromUserObject->id,
                $description ?: 'money_transfer',
            );

            $toUserWallet->increment('balance', $amount);
            $this->transactionService->createIncomingTransaction(
                TransactionTypeEnum::TRANSFER,
                $amount,
                $toUserObject->id,
                $description ?: 'money_transfer',
            );
        });
    }

    private function depositOrWithdrawal(...$args): void
    {
        DB::transaction(function () use ($args) {
            $isDeposit = $args[0];
            $amount = $args[1];
            $user = $args[2] ?? auth()->user();
            $userWallet = WalletHelper::getUserWallet($user, $this->userModel);
            [$adminWallet, $admin] = WalletHelper::getAdminWallet($this->walletModel);
            //TODO make bank transfer

            //TODO Update Wallets and store transactions

            $builder = $this->walletModel::query()->whereIn('user_id', [
                $userWallet->user_id,
                $adminWallet->user_id,
            ]);

            if ($isDeposit) {
                $builder->increment('balance', $amount);

                $this->transactionService->createIncomingTransaction(TransactionTypeEnum::DEPOSIT, $amount, auth()->id(), 'deposit');
            } else {
                //TODO has enough balance
                $this->throwHasNotEnoughBalanceException($amount, $userWallet);
                $this->throwHasNotEnoughBalanceException($amount, $adminWallet);

                $builder->decrement('balance', $amount);

                $this->transactionService->createOutGoingTransaction(TransactionTypeEnum::WITHDRAW, $amount, auth()->id(), 'withdrawal');
            }
        });
    }

    public function hasEnoughBalance($amount, $userWallet): bool
    {
        return $userWallet->balance >= $amount;
    }

    /**
     * @throws WalletException
     */
    private function throwHasNotEnoughBalanceException($amount, $userWallet): void
    {
        if (! $this->hasEnoughBalance($amount, $userWallet)) {
            WalletException::notEnoughBalance($amount);
        }
    }

    /**
     * @throws ValidationErrorsException
     */
    public function getValidUsers(mixed $fromUser, mixed $toUser): array
    {
        $fromUserObject = $fromUser instanceof $this->userModel
            ? $fromUser
            : $this->userModel::query()
                ->when(true, fn (UserBuilder $b) => $b->whereValidWalletSender())
                ->find($fromUser);

        $toUserObject = $toUser instanceof $this->userModel
            ? $toUser
            : $this->userModel::query()
                ->when(true, fn (UserBuilder $b) => $b->whereValidWalletReceiver($fromUser))
                ->find($toUser);

        $errors = [];

        $this->validateUsers($errors, $fromUserObject, $toUserObject);

        if ($errors) {
            throw new ValidationErrorsException($errors);
        }

//        if (UserTypeEnum::getUserType($fromUserObject) == UserTypeEnum::ADMIN_EMPLOYEE) {
//            $fromUserObject = $this->userModel::query()->whereIsAdmin()->first();
//        }

        return [
            $fromUserObject,
            $toUserObject,
        ];
    }

    private function validateUsers(array &$errors, $fromUser, $toUser): void
    {
        if (! $fromUser) {
            $errors = [
                'sender' => translate_error_message('money_sender', 'not_exists'),
            ];

            return;
        }

        if (! $toUser) {
            $errors = [
                'receiver' => translate_error_message('money_receiver', 'not_exists'),
            ];

            return;
        }

        if ($fromUser->id == $toUser->id) {
            $errors = ['sender' => translate_word('transferring_to_the_same_user')];
        }
    }
}
