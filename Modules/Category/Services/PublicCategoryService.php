<?php

namespace Modules\Category\Services;

use Modules\Category\Models\Category;

class PublicCategoryService extends AdminCategoryService
{
    public function index()
    {
        return Category::query()->latest()->searchable(['name'], ['name'])->get();
    }
}
