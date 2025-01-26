<?php

namespace Modules\Category\Http\Controllers;

use App\Helpers\ToastHelper;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Category\Http\Requests\CategoryRequest;
use Modules\Category\Services\AdminCategoryService;

class AdminCategoryController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AdminCategoryService $adminCategoryService) {}

    public function index()
    {
        $categories = $this->adminCategoryService->index();

        return view('category::index', compact('categories'));
    }

    public function create()
    {
        return view('category::create');
    }

    public function show($id)
    {
        $item = $this->adminCategoryService->show($id);

        return view('category::edit', compact('item'));
    }

    public function store(CategoryRequest $request)
    {
        $this->adminCategoryService->store($request->validated());

        ToastHelper::successToast();
        return redirect()->route('categories.index');
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->adminCategoryService->update($request->validated(), $id);

        ToastHelper::successToast();
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $this->adminCategoryService->destroy($id);

        ToastHelper::successToast();
        return redirect()->route('categories.index');
    }
}
