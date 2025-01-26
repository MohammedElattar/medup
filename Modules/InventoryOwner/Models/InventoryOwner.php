<?php

namespace Modules\InventoryOwner\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\InventoryOwner\Models\Builders\InventoryOwnerBuilder;
use Modules\InventoryOwner\Traits\InventoryOwnerRelations;

class InventoryOwner extends Model
{
    use InventoryOwnerRelations, PaginationTrait, Searchable, SoftDeletes;

    protected $fillable = ['user_id'];

    public function newEloquentBuilder($query): InventoryOwnerBuilder
    {
        return new InventoryOwnerBuilder($query);
    }
}
