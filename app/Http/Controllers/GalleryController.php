<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller {

    public function index(){
        $albums = Album::latest()->with('categories')->get();
        return view('gallery.albums' , ['albums' => $albums]);
    }

    public function showAlbumsByCategory(AlbumCategory $category){
        return view('gallery.albums' , [ 'albums' => $category->albums()->get() ]);
    }

    public function showAlbumImages(Album $album){
        $images = Photo::whereAlbumId($album->id)->latest()->get();
        return view('gallery.images', ['images' => $images, 'album'=> $album ]);
    }



}
