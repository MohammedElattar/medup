<?php

namespace Modules\Review\Entities;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Review\Database\factories\ReviewFactory;
use Modules\Review\Entities\Builders\ReviewBuilder;
use Modules\Review\Traits\ReviewRelations;

class Review extends Model
{
    use HasFactory, HasUuids, PaginationTrait, ReviewRelations, Searchable;

    protected $fillable = [
        'rating',
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'description',
    ];

    protected $casts = [
        'rating' => 'double',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function newEloquentBuilder($query): ReviewBuilder
    {
        return new ReviewBuilder($query);
    }

    public static function newFactory(): ReviewFactory
    {
        return ReviewFactory::new();
    }
}
