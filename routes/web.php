<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth'], function(){

    Route::get("/", "AlbumsController@index")->name("albums");

    Route::get("/albums", "AlbumsController@index")->name("albums");

    Route::delete("/albums/{album}", "AlbumsController@delete")->where("album","[0-9]+");

    Route::get("/albums/create", "AlbumsController@create")->name("album.create");

    Route::post("/albums", "AlbumsController@save")->name("albums.save");

    Route::get("/albums/{id}", "AlbumsController@edit");

    Route::patch("/albums/{id}", "AlbumsController@store");

    Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name("album.getImages")->where("album", "[0-9]+");

    Route::resource("/photos","PhotosController");

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
