<?php

namespace Modules\Vendor\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\InventoryOwner\Traits\InventoryOwnerRelations;
use Modules\Vendor\Models\Builders\VendorBuilder;

class Vendor extends Model
{
    use InventoryOwnerRelations, PaginationTrait, Searchable, SoftDeletes;

    protected $fillable = ['user_id'];

    public function newEloquentBuilder($query): VendorBuilder
    {
        return new VendorBuilder($query);
    }
}
