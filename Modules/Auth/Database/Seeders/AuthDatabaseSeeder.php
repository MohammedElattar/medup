<?php

namespace Modules\Auth\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Vendor\Models\Vendor;
use Modules\Wallet\Database\factories\WalletFactory;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = UserTypeEnum::availableTypes();

        foreach ($userTypes as $type) {
            $alphaType = UserTypeEnum::alphaTypes()[$type];

            $user = User::create([
                'name' => $alphaType,
                'email' => $alphaType.'@admin.com',
                'phone' => fake()->e164PhoneNumber(),
                'status' => true,
                AuthEnum::VERIFIED_AT => now(),
                'password' => $alphaType,
                'type' => $type,
            ]);

            if ($type == UserTypeEnum::ADMIN) {
                $user->assignRole('admin');
            }

            if ($type == UserTypeEnum::INVENTORY_OWNER) {
                InventoryOwner::create(['user_id' => $user->id]);
            }

            if ($type == UserTypeEnum::VENDOR) {
                Vendor::create(['user_id' => $user->id]);
            }

            WalletFactory::new()->create(['user_id' => $user->id]);
        }
    }
}
