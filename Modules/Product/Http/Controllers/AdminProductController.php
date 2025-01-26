<?php

namespace Modules\Product\Http\Controllers;

use App\Exceptions\ValidationErrorsException;
use App\Helpers\ToastHelper;
use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Category\Models\Category;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Product\Http\Requests\AdminProductRequest;
use Modules\Product\Services\AdminProductService;

class AdminProductController extends Controller
{
  use HttpResponse;

  public function __construct(private readonly AdminProductService $adminProductService)
  {
  }

  public function index()
  {
    $products = $this->adminProductService->index();

    return view('product::index', compact('products'));
  }

  public function create()
  {
    return view('product::create', $this->getMenus());
  }

  public function edit($id)
  {
    $item = $this->adminProductService->show($id);

    return view('product::edit', array_merge(compact('item'), $this->getMenus()));
  }

  public function store(AdminProductRequest $request)
  {
    try {
      $this->adminProductService->store($request->validated());

      ToastHelper::successToast();
      return redirect()->route('products.index');
    } catch (ValidationErrorsException $e) {
      return redirect()->back()->withInput()->withErrors($e->getErrors());
    }
  }

  public function update(AdminProductRequest $request, $id)
  {
    try {
      $this->adminProductService->update($request->validated(), $id);

      ToastHelper::successToast();
      return redirect()->route('products.index');
    } catch (ValidationErrorsException $e) {
      return redirect()->back()->withInput()->withErrors($e->getErrors());
    }
  }

  public function destroy($id)
  {
    $this->adminProductService->destroy($id);

    ToastHelper::successToast();
    return redirect()->route('products.index');
  }

  private function getMenus(): array
  {
    $categories = Category::query()->latest()->get(['id', 'name']);
    $inventoryOwners = UserTypeEnum::getUserType() == UserTypeEnum::INVENTORY_OWNER
      ? collect()
      : InventoryOwner::query()
        ->latest()
        ->get()
        ->map(function ($owner) {
          $owner->name = $owner->user->name;

          return $owner;
        });

    return compact('categories', 'inventoryOwners');
  }
}
