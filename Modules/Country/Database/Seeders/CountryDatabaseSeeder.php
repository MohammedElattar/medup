<?php

namespace Modules\Country\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Country\Models\Country;

class CountryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Country::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput('country'),
            ]);
        }
    }
}
