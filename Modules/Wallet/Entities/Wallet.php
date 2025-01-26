<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\factories\WalletFactory;
use Modules\Wallet\Entities\Builders\WalletQueryBuilder;
use Modules\Wallet\Traits\WalletRelations;

class Wallet extends Model
{
    use HasFactory, WalletRelations;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'double',
        'incoming_transactions_sum_amount' => 'double',
        'outgoing_transactions_sum_amount' => 'double',
    ];

    public static function newFactory(): WalletFactory
    {
        return WalletFactory::new();
    }

    public function newEloquentBuilder($query): WalletQueryBuilder
    {
        return new WalletQueryBuilder($query);
    }
}
