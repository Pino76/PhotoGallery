<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate();
        AlbumCategory::truncate();
        Category::truncate();
        Album::truncate();
        Photo::truncate();

        User::factory(10)->has(
          Album::factory(2)->has(
              Photo::factory(10)
          )
        )->create();

        $this->call(CategorySeeder::class);
        $this->call(AlbumCategorySeeder::class);
    }
}
