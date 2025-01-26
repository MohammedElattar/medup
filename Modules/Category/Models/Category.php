<?php

namespace Modules\Category\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations, PaginationTrait, Searchable, SoftDeletes;

    protected $fillable = ['name'];

    protected $translatable = ['name'];
}
