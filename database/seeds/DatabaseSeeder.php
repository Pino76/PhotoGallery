<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Photo;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\AlbumsCategory;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Album::truncate();
        Photo::truncate();
        AlbumCategory::truncate();
        AlbumsCategory::truncate();
        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumCategoriesTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotoTable::class);
    }
}
