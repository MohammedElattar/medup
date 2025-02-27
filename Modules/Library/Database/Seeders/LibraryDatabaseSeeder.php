<?php

namespace Modules\Library\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Expert\Models\Expert;
use Modules\Library\Models\Library;
use Modules\Speciality\Models\Speciality;
use Modules\Tag\Models\Tag;

class LibraryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::query()->pluck('id')->toArray();
        $experts = Expert::query()->pluck('id')->toArray();
        $specialities = Speciality::query()->pluck('id')->toArray();

        for($i = 0; $i<100; $i++) {
            $library = Library::query()->create([
                'title' => fake()->name(),
                'description' => fake()->paragraph(),
                'expert_id' => fake()->randomElement($experts),
                'price' => fake()->randomFloat(2, 0, 1000),
                'pages_count' => fake()->numberBetween(1, 1000),
                'speciality_id' => fake()->randomElement($specialities),
            ]);
        }
    }
}
