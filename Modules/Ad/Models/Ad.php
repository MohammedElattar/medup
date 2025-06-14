<?php

namespace Modules\Ad\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Tile\Models\Tile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Ad extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, PaginationTrait, Searchable;

    protected $fillable = [
        'name',
    ];

    protected $translatable = [];

    public function image()
    {
        return MediaHelper::mediaRelationship($this, 'ad_image');
    }

    public function resetImage(): void
    {
        MediaHelper::resetImage($this, 'ad_image');
    }
}
