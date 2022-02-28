<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AlbumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = Category::all()->pluck('id');
        foreach(Album::all() AS $album){
            $category = $cats->shuffle()->toArray();
            AlbumCategory::create([
                'album_id' => $album->id,
                'category_id' => $category[0]
            ]);
        }
    }
}
