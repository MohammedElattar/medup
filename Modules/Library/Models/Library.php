<?php

namespace Modules\Library\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Library\Models\Builders\LibraryBuilder;
use Modules\Library\Traits\LibraryRelations;
use Modules\Order\Models\Order;
use Modules\Review\Traits\ReviewTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Library extends Model implements HasMedia
{
    use InteractsWithMedia, LibraryRelations, PaginationTrait, Searchable, ReviewTrait;

    protected $fillable = [
        'title',
        'description',
        'expert_id',
        'price',
        'pages_count',
        'speciality_id',
        'status',
        'rating_average',
    ];

    protected function casts()
    {
        return [
            'price' => 'double:2',
            'status' => 'boolean',
            'rating_average' => 'double',
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new LibraryBuilder($query);
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }
}
