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

Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'dashboard'
    ], function(){

    Route::get('/', 'AlbumsController@index')->name("albums");

    Route::get('/albums','AlbumsController@index')->name("albums");

    Route::get('/albums/{id}' , 'AlbumsController@show')->where('id','[0-9]+');

    Route::get('/albums/create', 'AlbumsController@create')->name('album.create');

    Route::get('/albums/{id}/edit','AlbumsController@edit')->where('id', '[0-9]+')->name('album.edit');

    Route::delete('/albums/{album}','AlbumsController@delete')->where("album", "[0-9]+")->name('album.delete');

    Route::patch('albums/{id}', 'AlbumsController@store')->name('album.patch');;

    Route::post('/albums','AlbumsController@save')->name("albums.save");

    Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name("album.getImages")->where("album", "[0-9]+");

    Route::resource('photos', 'PhotosController');

    Route::resource('categories', 'AlbumCategoryController');
});


#### Gallery Route

Route::group([ 'prefix' => 'gallery'], function() {

    Route::get('albums', 'GalleryController@index')->name('gallery.albums');
    Route::get('albums/category/{category}','GalleryController@showAlbumsByCategory')->name('gallery.album.category');
    Route::get('/{category_id?}', 'GalleryController@index')->name('gallery.albums');
    Route::get('album/{album}/images','GalleryController@showAlbumImages')->name('gallery.album.images');


});



Auth::routes();

Route::get('/' , 'GalleryController@index');

Route::get('home' , 'GalleryController@index');



