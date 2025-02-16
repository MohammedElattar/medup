<?php

namespace Modules\Blog\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Blog\Models\Blog;
use Modules\Blog\Transformers\BlogResource;

class PublicBlogController extends Controller
{
    use HttpResponse;

    public function __construct()
    {
    }

    public function index()
    {
        $blogs = Blog::query()
            ->latest()
            ->with(['image', 'tags:id,name'])
            ->paginatedCollection();

        return $this->paginatedResponse($blogs, BlogResource::class);
    }

    public function show($id)
    {
        $blog = Blog::query()->with(['image', 'tags:id,name'])->findOrFail($id);

        return $this->resourceResponse(BlogResource::make($blog));
    }
}
