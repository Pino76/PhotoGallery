<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller {

    public function index(){
        $albums = Album::latest()->get();
        foreach ($albums AS $album){
            return $album->categories;
        }
        return view('gallery.albums' , ['albums' => $albums]);
    }

    public function showAlbumImages(Album $album){
        $images = Photo::whereAlbumId($album->id)->latest()->get();
        return view('gallery.images', ['images' => $images, 'album'=> $album ]);
    }



}
