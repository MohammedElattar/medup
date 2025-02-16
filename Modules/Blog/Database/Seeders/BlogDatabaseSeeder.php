<?php

namespace Modules\Blog\Database\Seeders;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Seeder;
use Modules\Blog\Models\Blog;
use Modules\Tag\Models\Tag;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::query()->pluck('id')->toArray();

        for($i = 0; $i<30; $i++) {
            $blog = Blog::query()->create([
                'title' => TranslationHelper::generateFakeTranslatedInput(),
                'sub_title' => TranslationHelper::generateFakeTranslatedInput(),
                'content' => TranslationHelper::generateFakeTranslatedInput('paragraph'),
                'created_at' => fake()->dateTime(),
                'user' => fake()->name()
            ]);

            $blog->tags()->attach(fake()->randomElements($tags));
        }
    }
}
