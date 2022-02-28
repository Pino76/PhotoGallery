<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = ["abstract","animals","business","cats","city","food","fashion","people","sports","nature"];
        $user_id = User::inRandomOrder()->pluck('id')->first();
        foreach($category AS $cat){
            Category::create([
                "category_name" => $cat,
                "user_id" => $user_id
            ]);

        }
    }
}
