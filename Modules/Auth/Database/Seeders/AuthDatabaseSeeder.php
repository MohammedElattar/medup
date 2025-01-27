<?php

namespace Modules\Auth\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Expert\Models\Expert;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Student\Models\Student;
use Modules\Trainee\Models\Trainee;
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

            if($type == UserTypeEnum::EXPERT) {
              Expert::query()->create([
                'user_id' => $user->id,
              ]);
            }

            if($type == UserTypeEnum::STUDENT) {
              Student::query()->create([
                'user_id' => $user->id,
              ]);
            }

            if($type == UserTypeEnum::TRAINEE) {
              Trainee::query()->create([
                'user_id' => $user->id,
              ]);
            }
        }
    }
}
