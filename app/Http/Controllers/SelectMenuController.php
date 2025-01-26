<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Modules\Application\Models\Application;
use Modules\Application\Transformers\ApplicationResource;
use Modules\Brand\Models\Brand;
use Modules\Role\Models\Permission;
use Modules\Role\Models\Role;
use Modules\Role\Transformers\PermissionResource;
use Modules\Role\Transformers\RoleResource;
use Modules\Room\Models\Room;
use Modules\Room\Transformers\RoomResource;
use Modules\Shape\Models\Shape;
use Modules\TileTexture\Models\TileTexture;

class SelectMenuController extends Controller
{
    use HttpResponse;

    public function permissions(): JsonResponse
    {
        $permissions = Permission::query()
            ->latest()
            ->get(['id', 'name']);

        return $this->resourceResponse(PermissionResource::collection($permissions));
    }

    public function roles()
    {
        return $this->resourceResponse(
            RoleResource::collection(
                Role::latest()
                    ->where('id', '<>', 1)
                    ->get(['id', 'name'])
            )
        );
    }

    public function applications(): JsonResponse
    {
        return $this->resourceResponse(ApplicationResource::collection(Application::query()->latest()->get(['id', 'name'])));
    }

    public function shapes()
    {
        return $this->resourceResponse(ApplicationResource::collection(
            Shape::query()->latest()->get(['id', 'name']),
        ));
    }

    public function rooms()
    {
        return $this->resourceResponse(RoomResource::collection(
            Room::query()->latest()->get(['id', 'name']),
        ));
    }

    public function tileTextures()
    {
        return $this->resourceResponse(RoomResource::collection(TileTexture::query()->latest()->with('image')->get(['id', 'name'])));
    }

    public function filters()
    {
        return $this->resourceResponse([
            'applications' => ApplicationResource::collection(Application::query()->withCount('tiles')->latest()->get(['id', 'name'])),
            'rooms' => ApplicationResource::collection(Room::query()->latest()->withCount('tiles')->get(['id', 'name'])),
            'shapes' => ApplicationResource::collection(Shape::query()->latest()->withCount('tiles')->get(['id', 'name'])),
            'tile_textures' => ApplicationResource::collection(TileTexture::query()->latest()->with('image')->withCount('tiles')->get(['id', 'name'])),
            'brands' => ApplicationResource::collection(Brand::query()->latest()->withCount('tiles')->get(['id', 'name'])),
        ]);
    }
}
