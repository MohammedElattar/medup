<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Role\Database\Seeders\RoleDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleDatabaseSeeder::class,
            AuthDatabaseSeeder::class,
//            CategoryDatabaseSeeder::class,
//            ProductDatabaseSeeder::class,
        ]);
    }
}
