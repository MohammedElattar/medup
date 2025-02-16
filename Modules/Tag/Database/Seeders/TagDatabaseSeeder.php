<?php

namespace Modules\Tag\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Tag\Models\Tag;

class TagDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for($i = 0; $i<20; $i++)
        {
            Tag::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput()
            ]);
        }
    }
}
