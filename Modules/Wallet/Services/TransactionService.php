<?php

namespace Modules\Wallet\Services;

use Modules\Auth\Enums\UserTypeEnum;
use Modules\Wallet\Entities\Builders\TransactionQueryBuilder;
use Modules\Wallet\Entities\Transaction;

class TransactionService
{
    private Transaction $transactionModel;

    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    public function index()
    {
        $userId = request()->input('user_id');
        $userId = UserTypeEnum::getUserType() == UserTypeEnum::INVENTORY_OWNER ? auth()->id() : $userId;
        $incoming = request()->input('incoming');

        return $this->transactionModel::query()
            ->when(!is_null($userId), fn($q) => $q->where('user_id', $userId))
            ->when(true, fn(TransactionQueryBuilder $b) => $b->withOrderDetails())
            ->when(! is_null($incoming), fn (TransactionQueryBuilder $b) => $b->where('incoming', $incoming))
            ->latest()
            ->paginatedCollection();
    }

    public function show($id)
    {
        $userId = request()->input('user_id');
        $userId = UserTypeEnum::getUserType() == UserTypeEnum::INVENTORY_OWNER ? auth()->id() : $userId;

        return Transaction::query()
            ->when(!is_null($userId), fn($q) => $q->where('user_id', $userId))
            ->when(true, fn(TransactionQueryBuilder $b) => $b->withOrderDetails())
            ->findOrFail($id);
    }
    public function createIncomingTransaction(...$args): void
    {
        $this->incomingOrOutGoing(true, ...$args);
    }

    public function createOutGoingTransaction(...$args): void
    {
        $this->incomingOrOutGoing(false, ...$args);
    }

    private function incomingOrOutGoing(bool $incoming = false, ...$args): void
    {
        $amount = $args[0];
        $userId = $args[1] ?? auth()->id();
        $orderId = $args[2] ?? null;

        $this->transactionModel::create([
            'amount' => $amount,
            'user_id' => $userId,
            'incoming' => $incoming,
            'description' => 'transaction',
            'order_id' => $orderId,
        ]);
    }
}
