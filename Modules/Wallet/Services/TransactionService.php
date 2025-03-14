<?php

namespace Modules\Wallet\Services;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Entities\Builders\TransactionQueryBuilder;
use Modules\Wallet\Entities\Transaction;

class TransactionService
{
    private Transaction $transactionModel;

    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    public function index($userId)
    {
        $incoming = request()->input('incoming');
        $type = request()->input('type');

        return $this->transactionModel::query()
            ->when(true, fn (TransactionQueryBuilder $b) => $b->whereShowable($userId))
            ->with([
                'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(),
            ])
            ->when(! is_null($incoming), fn (TransactionQueryBuilder $b) => $b->where('incoming', $incoming))
            ->when(! is_null($type), fn (TransactionQueryBuilder $b) => $b->where('type', $type))
            ->latest()
            ->paginatedCollection();
    }

    public function createIncomingTransaction(int $type, ...$args): void
    {
        $this->incomingOrOutGoing($type, true, ...$args);
    }

    public function createOutGoingTransaction(int $type, ...$args): void
    {
        $this->incomingOrOutGoing($type, false, ...$args);
    }

    private function incomingOrOutGoing(int $type, bool $incoming = false, ...$args): void
    {
        $amount = $args[0];
        $userId = $args[1] ?? auth()->id();
        $description = $args[2] ?? null;

        $this->transactionModel::create([
            'type' => $type,
            'amount' => $amount,
            'user_id' => $userId,
            'incoming' => $incoming,
            'description' => $description,
        ]);
    }
}
