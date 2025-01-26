<?php

namespace Modules\Order\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Order\Models\Builders\OrderBuilder;
use Modules\Product\Models\Product;

class Order extends Model
{
    use PaginationTrait, Searchable;

    protected $fillable = [
        'total',
        'name',
        'email',
        'phone',
        'product_id',
        'vendor_id',
        'new_price',
        'quantity',
        'original_price',
    ];

    public function newEloquentBuilder($query)
    {
        return new OrderBuilder($query);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
