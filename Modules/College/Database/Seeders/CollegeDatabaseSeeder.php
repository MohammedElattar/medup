<?php

namespace Modules\College\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\College\Models\College;

class CollegeDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            College::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
            ]);
        }
    }
}
