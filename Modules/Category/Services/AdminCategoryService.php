<?php

namespace Modules\Category\Services;

use App\Exceptions\ValidationErrorsException;
use Modules\Category\Models\Category;

class AdminCategoryService
{
    public function index()
    {
        return Category::query()
            ->latest()
            ->searchable(['name'], ['name'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Category::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        Category::create($data);
    }

    public function update(array $data, $id)
    {
        $category = Category::query()->findOrFail($id);
        $category->update($data);
    }

    public function destroy($id)
    {
        Category::query()->findOrFail($id)->delete();
    }

    /**
     * @throws ValidationErrorsException
     */
    public function exists($id, string $errorKey = 'category_id')
    {
        $item = Category::query()->find($id);

        if (! $item) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('category', 'not_exists'),
            ]);
        }

        return $item;
    }
}
