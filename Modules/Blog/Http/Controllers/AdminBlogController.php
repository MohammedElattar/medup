<?php

namespace Modules\Blog\Http\Controllers;

use App\Helpers\FlasherHelper;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Models\Blog;
use Modules\Blog\Services\AdminBlogService;
use Modules\Tag\Models\Tag;

class AdminBlogController extends Controller
{
   use HttpResponse;

   public function __construct(private readonly AdminBlogService $adminBlogService)
   {
   }

    public function index()
   {
       $blogs = $this->adminBlogService->index();

       return view('blog::index', compact('blogs'));
   }

   public function create()
   {
       return view('blog::create', $this->getMenus());
   }

   public function edit($id)
   {
       $blog = Blog::query()->with('image')->findOrFail($id);

       return view('blog::edit', array_merge(compact('blog'), $this->getMenus()));
   }

   public function store(BlogRequest $request)
   {
       $this->adminBlogService->store($request->validated());

       FlasherHelper::success(translate_success_message('blog', 'created_female'));

       return redirect()->route('blogs.index');
   }

   public function update(BlogRequest $request, $id)
   {
       $this->adminBlogService->update($request->validated(), $id);

       FlasherHelper::success(translate_success_message('blog', 'updated_female'));

       return redirect()->route('blogs.index');
   }

   public function destroy($id)
   {
       Blog::query()->findOrFail($id)->delete();

       FlasherHelper::success(translate_success_message('blog', 'deleted_female'));

       return redirect()->route('blogs.index');
   }

   private function getMenus()
   {
       $tags = Tag::query()->latest()->get(['id', 'name']);

       return compact('tags');
   }
}
