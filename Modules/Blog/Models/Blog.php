<?php

namespace Modules\Blog\Models;

use App\Helpers\MediaHelper;
use App\Traits\HasTranslations;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Models\Tag;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasTranslations, PaginationTrait, Searchable, InteractsWithMedia;

    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'created_at',
        'user',
    ];

    protected $translatable = [
        'title',
        'sub_title',
        'content',
    ];

    public function image()
    {
        return MediaHelper::mediaRelationship($this, 'blog_image');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
