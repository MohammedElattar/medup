<?php

namespace Modules\City\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\City\Models\City;
use Modules\Country\Models\Country;

class CityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::query()->pluck('id')->toArray();

        for($i = 0; $i<100; $i++) {
            City::query()->create([
              'name' => TranslationHelper::generateFakeTranslatedInput('city'),
              'country_id' => fake()->randomElement($countries),
            ]);
        }
    }
}
