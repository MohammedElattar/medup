<?php

namespace Modules\InventoryOwner\Http\Controllers;

use App\Exceptions\ValidationErrorsException;
use App\Helpers\ToastHelper;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\InventoryOwner\Http\Requests\InventoryOwnerRequest;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\InventoryOwner\Services\AdminInventoryOwnerService;

class InventoryOwnerController extends Controller
{
    use HttpResponse;

    private AdminInventoryOwnerService $inventoryOwnerService;

    public function __construct()
    {
        $this->inventoryOwnerService = new AdminInventoryOwnerService(app(InventoryOwner::class));
    }

    public function index()
    {
        $data = $this->inventoryOwnerService->index();
        $route = 'inventory-owners';
        $title = 'inventory_owners';

        return view('inventoryowner::index', compact('data', 'route', 'title'));
    }

    public function create()
    {
        $route = 'inventory-owners';

        return view('inventoryowner::create', compact('route'));
    }

    public function show($id)
    {
        $item = $this->inventoryOwnerService->show($id);
        $route = 'inventory-owners';

        return view('inventoryowner::edit', compact('item', 'route'));
    }

    public function store(InventoryOwnerRequest $request)
    {
        try {
            $this->inventoryOwnerService->store($request->validated());

            ToastHelper::successToast();
            return redirect()->route('inventory-owners.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function update(InventoryOwnerRequest $request, $id)
    {
        try {
            $this->inventoryOwnerService->update($request->validated(), $id);

            ToastHelper::successToast();
            return redirect()->route('inventory-owners.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function destroy($id)
    {
        $this->inventoryOwnerService->destroy($id);
        ToastHelper::successToast();

        return redirect()->route('inventory-owners.index');
    }
}
