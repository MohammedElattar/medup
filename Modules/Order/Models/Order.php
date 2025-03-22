<?php

namespace Modules\Order\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Order\Models\Builders\OrderBuilder;

class Order extends Model
{
    use PaginationTrait;

    protected $fillable = [
        'user_id',
        'orderable_type',
        'orderable_id',
        'price',
    ];

    protected function casts()
    {
        return [
            'price' => 'double',
            'reviewed' => 'boolean',
        ];
    }

    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    public function newEloquentBuilder($query)
    {
        return new OrderBuilder($query);
    }

    public function review(array $data)
    {
        $this->forceFill([
            'reviewed' => true,
        ])->save();

        $this->orderable->storeReview($data);
        $this->orderable->recalculateRating();
    }
}
