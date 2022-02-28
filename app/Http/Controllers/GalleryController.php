<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        //$albums = Album::with('categories')->get();

        $albums = Album::with('categories')->latest()->paginate(10);
        return view('gallery.albums' , ['albums' => $albums , "category_id" => null]);
    }

    public function showAlbumImages(Album $album){
        $images = Photo::whereAlbumId($album->id)->latest()->paginate(50);
        return view("gallery.images" , ["images"=>$images , "album"=>$album]);
    }

    public function showCategoryAlbums(Category $category){

        $albums = $category->albums()->with('categories')->latest()->paginate(5);
        return view('gallery.albums' , ["albums" => $albums, "category_id" => $category->id]);

    }
}
