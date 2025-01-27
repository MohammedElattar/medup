<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Country\Database\Seeders\CountryDatabaseSeeder;
use Modules\Skill\Database\Seeders\SkillDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountryDatabaseSeeder::class,
            CityDatabaseSeeder::class,
            SkillDatabaseSeeder::class,
            AuthDatabaseSeeder::class,
        ]);
    }
}
