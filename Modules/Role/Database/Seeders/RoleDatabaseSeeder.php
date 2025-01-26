<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Role\Helpers\PermissionCacheHelper;
use Modules\Role\Helpers\PermissionHelper;
use Modules\Role\Helpers\RolePermissionDefinition;
use Modules\Role\Models\Role;

class RoleDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $this->createRoles();
    }

    public function createPermissions()
    {
        $allPermissions = [
            ...RolePermissionDefinition::permissions(),
        ];

        $latestPermissions = [];

        foreach ($allPermissions as $parentPermission => $operations) {
            $permission = [];
            foreach ($operations as $operation) {
                $permissionName = PermissionHelper::generatePermissionName($operation, $parentPermission);
                $permission['name'] = $permissionName;

                PermissionHelper::permissionModel()::firstOrCreate(['name' => $permission['name']], $permission);
                $latestPermissions[] = $permission;
            }
        }

        PermissionCacheHelper::setCachedPermissions();

        $permissions = collect($latestPermissions)->pluck('name')->toArray();

        return PermissionHelper::permissionModel()::whereIn('name', $permissions)->get();
    }

    private function createRoles()
    {
        $allPermissions = $this->createPermissions();

        $role = Role::query()->firstOrCreate(['name' => 'admin'], ['name' => 'admin']);

        $role->permissions()->sync($allPermissions->pluck('id')->toArray());
    }
}
