<?php

namespace Modules\Vendor\Http\Controllers;

use App\Exceptions\ValidationErrorsException;
use App\Helpers\ToastHelper;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\InventoryOwner\Services\AdminInventoryOwnerService;
use Modules\Vendor\Http\Requests\VendorRequest;
use Modules\Vendor\Models\Vendor;

class VendorController extends Controller
{
    use HttpResponse;

    private AdminInventoryOwnerService $adminInventoryOwnerService;

    public function __construct()
    {
        $this->adminInventoryOwnerService = new AdminInventoryOwnerService(
            app(Vendor::class),
            UserTypeEnum::VENDOR,
            'vendor_id',
            'vendor'
        );
    }

    public function index()
    {
        $data = $this->adminInventoryOwnerService->index();
        $route = 'vendors';
        $title = 'vendors';

        return view('inventoryowner::index', compact('data', 'route', 'title'));
    }

    public function create()
    {
        $route = 'vendors';

        return view('inventoryowner::create', compact('route'));
    }

    public function show($id)
    {
        $item = $this->adminInventoryOwnerService->show($id);
        $route = 'vendors';

        return view('inventoryowner::edit', compact('item', 'route'));
    }

    public function store(VendorRequest $request)
    {
        try {
            $this->adminInventoryOwnerService->store($request->validated());

            ToastHelper::successToast();
            return redirect()->route('vendors.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function update(VendorRequest $request, $id)
    {
        try {
            $this->adminInventoryOwnerService->update($request->validated(), $id);

            ToastHelper::successToast();
            return redirect()->route('vendors.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function destroy($id)
    {
        $this->adminInventoryOwnerService->destroy($id);

        return redirect()->route('vendors.index');
    }
}
