<?php

namespace Modules\Blog\Services;

use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Models\Blog;
use Modules\Tag\Services\TagService;

class AdminBlogService
{
    public function index()
    {
        return Blog::query()
            ->latest()
            ->with('image')
            ->searchable(['title', 'sub_title'], ['title', 'sub_title'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Blog::query()->with('image')->findOrFail($id);
    }

    public function store(array $data)
    {
        (new TagService())->exist($data['tags']);

        DB::transaction(function() use ($data){
            $blog = Blog::query()->create($data);

            $blog->tags()->attach($data['tags']);
            $imageService = new ImageService($blog, $data);
            $imageService->storeOneMediaFromRequest('blog_image', 'image');
        });
    }

    public function update(array $data, $id)
    {
        (new TagService())->exist($data['tags']);
        $blog = Blog::query()->findOrFail($id);

        DB::transaction(function() use ($data, $blog){
            $blog->update($data);

            $blog->tags()->sync($data['tags']);
            $imageService = new ImageService($blog, $data);
            $imageService->updateOneMedia('blog_image', 'image');
        });
    }
}
