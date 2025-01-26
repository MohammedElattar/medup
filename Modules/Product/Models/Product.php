<?php

namespace Modules\Product\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Models\Builders\ProductBuilder;
use Modules\Product\Traits\ProductRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, PaginationTrait, ProductRelations, Searchable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'category_id',
        'inventory_owner_id',
    ];

    protected $translatable = ['name', 'description'];

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }

    public function resetImage()
    {
        MediaHelper::resetImage($this, 'products');
    }
}
