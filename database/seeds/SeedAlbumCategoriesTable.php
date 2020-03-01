<?php

use Illuminate\Database\Seeder;
use App\Models\AlbumCategory;
use App\Models\User;
class SeedAlbumCategoriesTable extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){
        $category = ["abstract" , "city" , "people" , "transport" , "food" , "nature" , "business" , "nightlife" , "sports"];

        foreach ($category AS $cat){
            AlbumCategory::create(
                [
                    'category_name' => $cat,
                    'user_id' => User::inRandomOrder()->first()->id
                    ]
            );
        }
    }
}
