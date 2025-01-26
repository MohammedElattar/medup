<?php

namespace Modules\Product\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Product\Models\Product;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventoryOwners = InventoryOwner::query()->pluck('id')->toArray();
        $categories = Category::query()->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Product::query()->create([
                'name' => TranslationHelper::generateFakeTranslatedInput(),
                'description' => TranslationHelper::generateFakeTranslatedInput('sentence'),
                'quantity' => rand(100, 1000),
                'price' => rand(100, 500),
                'category_id' => fake()->randomElement($categories),
                'inventory_owner_id' => fake()->randomElement($inventoryOwners),
            ]);
        }
    }
}
