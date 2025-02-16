<?php

namespace Modules\Tag\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Tag extends Model
{
    use HasTranslations, PaginationTrait, Searchable;

    protected $fillable = ['name'];

    protected $translatable = ['name'];
}
