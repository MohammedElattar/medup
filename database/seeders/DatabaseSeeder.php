<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Country\Database\Seeders\CountryDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountryDatabaseSeeder::class,
            CityDatabaseSeeder::class,
            AuthDatabaseSeeder::class,
        ]);
    }
}
