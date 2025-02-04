<?php

namespace Modules\City\Database\Seeders;

use App\Helpers\JsonParserHelper;
use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\City\Models\City;
use Modules\Country\Models\Country;

class CityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $mappedCountries = [];
        Country::query()->cursor()->each(function($i) use (&$mappedCountries){
            $mappedCountries[$i->name] = $i->id;
        });

        JsonParserHelper::parse(storage_path('countries/cities.json'))
            ->seedChunks(City::class, function($item) use ($mappedCountries){
                $cities = [];

                foreach($item['cities'] as $city){
                    if(isset($mappedCountries[$item['country']])) {
                        $cities[] = [
                            'name' => json_encode([
                                'en' => $city['label'],
                                'ar' => $city['label_ar'],
                            ]),
                            'country_id' => $mappedCountries[$item['country']],
                        ];
                    }
                }

                return $cities;
            }, shouldMerge: true, size: 1);
    }
}
