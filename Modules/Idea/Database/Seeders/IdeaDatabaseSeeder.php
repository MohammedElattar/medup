<?php

namespace Modules\Idea\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Idea\Models\Idea;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;

class IdeaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experts = Expert::query()->pluck('id')->toArray();
        $specialities = Speciality::query()->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Idea::query()->create([
                'title' => fake()->name(),
                'description' => fake()->paragraph(10),
                'expert_id' => fake()->randomElement($experts),
                'speciality_id' => fake()->randomElement($specialities),
                'status' => fake()->boolean(),
                'orcid_number' => fake()->url(),
            ]);
        }
    }
}
