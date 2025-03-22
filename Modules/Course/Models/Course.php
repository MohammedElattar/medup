<?php

namespace Modules\Course\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Models\Builders\CourseBuilder;
use Modules\Course\Traits\CourseRelations;
use Modules\Review\Traits\ReviewTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use PaginationTrait, Searchable, InteractsWithMedia, CourseRelations, ReviewTrait;

    protected $fillable = [
        'name',
        'link',
        'expert_id',
        'speciality_id',
        'price',
        'rating_average',
        'description',
    ];

    public function newEloquentBuilder($query)
    {
        return new CourseBuilder($query);
    }

    protected function casts()
    {
        return [
            'price' => 'double:2',
            'rating_average' => 'double:2',
        ];
    }
}
