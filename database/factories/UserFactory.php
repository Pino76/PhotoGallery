<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use App\Models\Album;
use App\Models\Photo;
use App\Models\AlbumCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$img = ["abstract" , "city" , "people" , "transport" , "food" , "nature" , "business" , "nightlife" , "sports"];

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Album::class, function (Faker $faker) use ($img) {
    return [
        'album_name' => $faker->name,
        'album_thumb' => $faker->imageUrl($width=640, $height=480, $faker->randomElement($img)),
        'description' => $faker->text(128),
        'user_id' => User::inRandomOrder()->first()->id
    ];
});

$factory->define(Photo::class, function (Faker $faker) use ($img) {
    return [
        'album_id' => Album::inRandomOrder()->first()->id,
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl($width=640, $height=480, $faker->randomElement($img))
    ];
});


