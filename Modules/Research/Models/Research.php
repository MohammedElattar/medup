<?php

namespace Modules\Research\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Research extends Model implements HasMedia
{
    use InteractsWithMedia, PaginationTrait, Searchable;

    protected $fillable = [
        'title',
        'contributors',
        'skills',
        'notes',
        'user_id'
    ];

    public function file()
    {
        return MediaHelper::mediaRelationship($this, 'research_file');
    }
}
