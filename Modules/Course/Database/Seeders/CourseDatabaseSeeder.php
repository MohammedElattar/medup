<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Course\Models\Course;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experts = Expert::query()->pluck('id')->toArray();
        $specialities = Speciality::query()->pluck('id')->toArray();

        for($i = 0; $i<100; $i++) {
            Course::query()->create([
                'name' => fake()->name(),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(1, 500, 1000),
                'link' => fake()->url(),
                'expert_id' => fake()->randomElement($experts),
                'speciality_id' => fake()->randomElement($specialities),
            ]);
        }
    }
}
