<?php

namespace Modules\Testimonial\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Testimonial\Models\Testimonial;

class TestimonialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->where('type', '<>', UserTypeEnum::ADMIN)->pluck('id')->toArray();

        for($i = 0; $i<100; $i++) {
            Testimonial::query()->create([
                'user_id' => fake()->randomElement($users),
                'content' => fake()->paragraph(),
            ]);
        }
    }
}
