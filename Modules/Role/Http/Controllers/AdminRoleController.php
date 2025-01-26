<?php

namespace Modules\Role\Http\Controllers;

use App\Exceptions\ValidationErrorsException;
use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Role\Http\Requests\RoleRequest;
use Modules\Role\Models\Permission;
use Modules\Role\Services\RoleService;

class AdminRoleController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly RoleService $roleService) {}

    public function index()
    {
        $roles = $this->roleService->index();

        return view('role::index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::query()
            ->latest()
            ->get(['id', 'name']);

        return view('role::create', compact('permissions'));
    }

    public function show($id)
    {
        $role = $this->roleService->show($id);
        $permissions = Permission::query()
            ->latest()
            ->get(['id', 'name']);

        return view('role::show', compact('role', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $this->roleService->store($request->validated());

            return redirect()->route('roles.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $this->roleService->update($request->validated(), $id);

            return redirect()->route('roles.index');
        } catch (ValidationErrorsException $e) {
            return redirect()->back()->withInput()->withErrors($e->getErrors());
        }
    }

    public function destroy($id)
    {
        $this->roleService->destroy($id);

        return redirect()->route('roles.index');
    }
}
