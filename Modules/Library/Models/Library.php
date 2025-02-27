<?php

namespace Modules\Library\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Library\Models\Builders\LibraryBuilder;
use Modules\Library\Traits\LibraryRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Library extends Model implements HasMedia
{
    use InteractsWithMedia, LibraryRelations, PaginationTrait, Searchable;

    protected $fillable = [
        'title',
        'description',
        'expert_id',
        'price',
        'pages_count',
        'speciality_id',
        'status',
    ];

    protected function casts()
    {
        return [
            'price' => 'double',
            'status' => 'boolean',
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new LibraryBuilder($query);
    }
}
