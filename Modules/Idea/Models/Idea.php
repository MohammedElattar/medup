<?php

namespace Modules\Idea\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Collaborate\Models\Builders\CollaborateBuilder;
use Modules\Collaborate\Traits\CollaborateRelations;

class Idea extends Model
{
    use PaginationTrait, Searchable, CollaborateRelations;

    protected $fillable = [
        'title',
        'description',
        'expert_id',
        'speciality_id',
        'status',
        'orcid_number',
    ];

    protected function casts()
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function newEloquentBuilder($query): CollaborateBuilder
    {
        return new CollaborateBuilder($query);
    }
}
