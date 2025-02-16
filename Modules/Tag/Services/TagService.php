<?php

namespace Modules\Tag\Services;

use App\Exceptions\ValidationErrorsException;
use Illuminate\Support\Str;
use Modules\Tag\Models\Tag;

class TagService
{
    public function index()
    {
        return Tag::query()->latest()->paginatedCollection();
    }

    public function show($id)
    {
        return Tag::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        Tag::query()->create($data);
    }

    public function update(array $data, $id)
    {
        $tag = Tag::query()->findOrFail($id);
        $tag->update($data);
    }

    public function destroy($id)
    {
        Tag::query()->findOrFail($id)->delete();
    }

    /**
     * @throws ValidationErrorsException
     */
    public function exists($id, string $errorKey = 'tag_id')
    {
        $item = Tag::query()->find($id);

        if (! $item) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('tag', 'not_exists'),
            ]);
        }

        return $item;
    }

    public function exist(array $ids, string $errorKey = 'tags.*')
    {
        $tags = Tag::query()->whereIntegerInRaw('id', $ids)->get();
        $existingIds = $tags->pluck('id')->toArray();

        foreach($ids as $id) {
            if(! in_array($id, $existingIds)) {
                throw new ValidationErrorsException([
                    'tags' =>  translate_success_message('tag', 'not_exists'),
                ]);
            }
        }

        return $tags;
    }
}
