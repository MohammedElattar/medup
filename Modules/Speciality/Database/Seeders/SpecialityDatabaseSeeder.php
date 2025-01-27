<?php

namespace Modules\Speciality\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Speciality\Models\Speciality;
use Modules\College\Models\College;

class SpecialityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = College::query()->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Speciality::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
                'college_id' => fake()->randomElement($colleges),
            ]);
        }
    }
}
