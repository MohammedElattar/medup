<?php

namespace Modules\Auth\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\DegreeEnum;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\City\Models\City;
use Modules\Expert\Models\Expert;
use Modules\Skill\Models\Skill;
use Modules\Speciality\Models\Speciality;
use Modules\Student\Models\Student;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = UserTypeEnum::availableTypes();
        $cities = City::query()->pluck('id')->toArray();
        $specialities = Speciality::query()->pluck('id')->toArray();
        $skills = Skill::query()->pluck('id')->toArray();

        foreach ($userTypes as $type) {
            $alphaType = UserTypeEnum::alphaTypes()[$type];
            $user = User::create([
                'first_name' => fake()->name(),
                'middle_name' => fake()->name(),
                'name' => fake()->name(),
                'email' => $alphaType . '@admin.com',
                'phone' => fake()->e164PhoneNumber(),
                'status' => true,
                AuthEnum::VERIFIED_AT => now(),
                'password' => $alphaType,
                'type' => $type,
            ]);

            switch ($type) {
                case UserTypeEnum::STUDENT:
                case UserTypeEnum::TRAINEE:
                    Student::query()->create([
                        'user_id' => $user->id,
                        'city_id' => fake()->randomElement($cities),
                        'speciality_id' => fake()->randomElement($specialities),
                    ]);
                    break;

                case UserTypeEnum::EXPERT:
                case UserTypeEnum::EXPERT_LEARNER:
                    $expert = Expert::query()->create([
                        'user_id' => $user->id,
                        'city_id' => fake()->randomElement($cities),
                        'speciality_id' => fake()->randomElement($specialities),
                        'headline' => fake()->sentence(),
                        'graduation_year' => fake()->year(),
                        'degree' => fake()->randomElement(DegreeEnum::toArray()),
                    ]);
                    $expert->skills()->attach(fake()->randomElements($skills));
                    break;
            }
        }
    }
}
