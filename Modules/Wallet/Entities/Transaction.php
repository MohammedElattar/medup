<?php

namespace Modules\Wallet\Entities;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Database\factories\TransactionFactory;
use Modules\Wallet\Entities\Builders\TransactionQueryBuilder;
use Modules\Wallet\Traits\TransactionRelations;

class Transaction extends Model
{
    use HasFactory, PaginationTrait, TransactionRelations;

    protected $fillable = [
        'user_id',
        'amount',
        'incoming',
        'description',
        'from_admin',
        'order_id',
    ];

    protected $casts = [
        'incoming' => 'boolean',
        'amount' => 'double',
        'from_admin' => 'boolean',
    ];

    public static function newFactory(): TransactionFactory
    {
        return TransactionFactory::new();
    }

    public function newEloquentBuilder($query): TransactionQueryBuilder
    {
        return new TransactionQueryBuilder($query);
    }
}
