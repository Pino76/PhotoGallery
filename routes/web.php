<?php


use Illuminate\Support\Facades\Route;
use App\Models\Album;
use App\Models\User;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades;
use App\Mail\testEmail;
use App\Mail\TestMd;
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

Route::get('/', function () {
    return redirect()->route('gallery.index');
});


Route::get('/users', function(){
    return User::with('albums')->paginate(92);
});

Route::get('/album', function (){
    return Album::paginate(5);
});

#Route::get('/albums' , [AlbumsController::class, 'index']);


Route::middleware(['auth'])->prefix('dashboard')->group(function(){
    Route::resource('/albums',AlbumsController::class);
    Route::get('/albums/{album}/images', [AlbumsController::class, 'getImages'])->name('albums.images');
    Route::resource('photos', PhotosController::class);
    Route::resource('categories', CategoryController::class);
});



Route::group(["prefix"=>"gallery"], function (){
    Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('albums', [GalleryController::class, 'index']);
    Route::get('album/{album}/images', [GalleryController::class, 'showAlbumImages'])->name('gallery.album.images');
    Route::get('categories/{category}/albums', [GalleryController::class, 'showCategoryAlbums'])->name('gallery.categories.albums');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';


Route::get('testMail' , function (){
   # Mail::send(new testEmail(Auth::user()));
    Mail::to('gigginopezzotto@libero.it')->send(new TestMd(Auth::user()));
});



