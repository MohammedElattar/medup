<?php

namespace Modules\Ad\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Ad\Models\Ad;
use Modules\Tile\Models\Tile;

class AdDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiles = Tile::query()->select(['id'])->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Ad::create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
                'description' => TranslationHelper::generateFakeTranslatedInput(),
                'tile_id' => fake()->randomElement($tiles),
            ]);
        }
    }
}
