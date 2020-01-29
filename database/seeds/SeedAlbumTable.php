<?php

use Illuminate\Database\Seeder;
use App\Models\AlbumCategory;
use App\Models\AlbumsCategory;
use App\Models\Album;
class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
       // DB::statement("SET FOREIGN_KEY_CHECKS=0;"); // disabilitare momentaneamente la FK e svuotare la tabella
       // Album::truncate();
        factory(Album::class,10)->create()->each(function ($album){
                $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id');
                $cats->each(function ($cat_id) use($album){
                    AlbumsCategory::create([
                        'album_id' => $album->id,
                        'category_id' => $cat_id
                    ]);
                });
            });
    }
}
