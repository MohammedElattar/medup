<?php

namespace Modules\Idea\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Models\Expert;
use Modules\Idea\Models\Builders\IdeaBuilder;
use Modules\Speciality\Models\Speciality;

class Idea extends Model
{
    use PaginationTrait, Searchable;

    protected $fillable = [
        'title',
        'description',
        'price',
        'expert_id',
        'speciality_id',
        'status',
    ];

    protected function casts()
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function newEloquentBuilder($query): IdeaBuilder
    {
        return new IdeaBuilder($query);
    }
}
