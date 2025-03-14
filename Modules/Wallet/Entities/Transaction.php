<?php

namespace Modules\Wallet\Entities;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Entities\Builders\TransactionQueryBuilder;
use Modules\Wallet\Traits\TransactionRelations;

class Transaction extends Model
{
    use HasUuids, PaginationTrait, TransactionRelations;

    protected $fillable = [
        'user_id',
        'amount',
        'incoming',
        'description',
        'main_order_id',
        'sub_order_id',
        'from_admin',
        'materials_total',
        'service_cost',
        'maintenance_invoice_id',
    ];

    protected $casts = [
        'incoming' => 'boolean',
        'amount' => 'double',
        'from_admin' => 'boolean',
        'service_cost',
    ];

    public function newEloquentBuilder($query): TransactionQueryBuilder
    {
        return new TransactionQueryBuilder($query);
    }
}
