<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Photo;
use App\Models\Album;
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
        Photo::truncate();
        Album::truncate();
        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotoTable::class);
    }
}
