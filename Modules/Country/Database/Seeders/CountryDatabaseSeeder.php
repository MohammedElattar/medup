<?php

namespace Modules\Country\Database\Seeders;

use App\Helpers\JsonParserHelper;
use Illuminate\Database\Seeder;
use Modules\Country\Models\Country;

class CountryDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        JsonParserHelper::parse(storage_path('countries/countries.json'))
            ->seedChunks(Country::class, function($item){
                return [
                    'name' => json_encode([
                        'en' => $item['label'],
                        'ar' => $item['label_ar'],
                    ])
                ];
            });
    }
}
