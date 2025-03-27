<?php

namespace Modules\AboutUs\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AboutUs\Models\AboutUs;

class AboutUsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUs::query()->delete();
        DB::statement('ALTER TABLE about_us AUTO_INCREMENT = 1');

        for ($i = 0; $i < 4; $i++) {
            AboutUs::query()->create([
                'title' => TranslationHelper::generateFakeTranslatedInput(),
                'description' => TranslationHelper::generateFakeTranslatedInput('sentence'),
            ]);
        }
    }
}
