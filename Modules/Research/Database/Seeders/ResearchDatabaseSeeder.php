<?php

namespace Modules\Research\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Research\Models\Research;

class ResearchDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0;$i<100; $i++) {
            Research::query()->create([
                'title' => fake()->name(),
                'contributors' => fake()->name(),
                'skills' => fake()->name(),
                'user_id' => 2,
                'notes' => fake()->name(),
            ]);
        }
    }
}
