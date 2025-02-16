<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seeders\AuthDatabaseSeeder;
use Modules\Blog\Database\Seeders\BlogDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\College\Database\Seeders\CollegeDatabaseSeeder;
use Modules\Country\Database\Seeders\CountryDatabaseSeeder;
use Modules\Research\Database\Seeders\ResearchDatabaseSeeder;
use Modules\Skill\Database\Seeders\SkillDatabaseSeeder;
use Modules\Speciality\Database\Seeders\SpecialityDatabaseSeeder;
use Modules\Tag\Database\Seeders\TagDatabaseSeeder;
use Modules\Testimonial\Database\Seeders\TestimonialDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountryDatabaseSeeder::class,
            CityDatabaseSeeder::class,
            SkillDatabaseSeeder::class,
            CollegeDatabaseSeeder::class,
            SpecialityDatabaseSeeder::class,
            AuthDatabaseSeeder::class,
            TestimonialDatabaseSeeder::class,
            TagDatabaseSeeder::class,
            BlogDatabaseSeeder::class,
            ResearchDatabaseSeeder::class,
        ]);
    }
}
