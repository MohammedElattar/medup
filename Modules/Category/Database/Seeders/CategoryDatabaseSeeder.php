<?php

namespace Modules\Category\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Category::create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
            ]);
        }
    }
}
