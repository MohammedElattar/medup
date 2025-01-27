<?php

namespace Modules\Skill\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Skill\Models\Skill;

class SkillDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Skill::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
            ]);
        }
    }
}
