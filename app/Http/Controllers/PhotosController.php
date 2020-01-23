<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Http\Requests\PhotosRequest;
use App\Http\Requests\PhotosUpdateRequest;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Storage;

class PhotosController extends Controller{

    public function index(){
        return Photo::get();
    }


    public function create(Request $request){
        $id = $request->has('album_id') ? $request->input('album_id') : null;

        $album = Album::firstOrNew(["id" => $id]);

        $photo = new Photo();

        $albums = $this->getAlbums();

        return view("images.editimage" , ["album"=>$album, "photo"=>$photo, "albums"=>$albums ]);
    }


    public function store(PhotosRequest $request){
        $photo = new Photo();
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input("album_id");
        $this->processFile($photo);
        $photo->save();
        return redirect()->route("album.getImages", $photo->album_id);
    }


    public function show(Photo $photo){
        return $photo;
    }


    public function edit(Photo $photo){
        $album = $photo->album;
        $albums = $this->getAlbums();
        return view("images.editimage" , ["album"=>$album, "photo"=>$photo, "albums"=>$albums ]);
    }


    public function update(PhotosUpdateRequest $request, Photo $photo){
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $this->processFile($photo);
        $res = $photo->save();
        $message = $res ? "La foto  $photo->name è stata modificata " : "Errore durante la modifica della foto  $photo->name";
        session()->flash("message" , $message);
        return redirect()->route("album.getImages", $photo->album_id);
    }


    public function destroy(Photo $photo){
        $res = $photo->delete();
        if($res == true){
            $this->processFile($photo->id);
        }
        return (string)$res;
    }

    public function processFile(Photo $photo, Request $request = null){
        if(!$request){
            $request = request();
        }

        if(!$request->hasFile("img_path")){
            return false;
        }

        $file = $request->file("img_path");

        if(!$file->isValid()){
            return false;
        }

        $imgName = preg_replace("@[a-z0-9]i@", '_', $photo->name);
        $fileName = $imgName.'.'.$file->extension();
        $file->storeAs(env('IMG_DIR')."/".$photo->album_id , $fileName);
        $photo->img_path = env('IMG_DIR')."/".$photo->album_id."/".$fileName;

        return true;
    }


    public function deleteFile(Photo $photo){
        $disk = config('filesystems.default');
        if($photo->img_path && Storage::disk($disk)->has($photo->img_path)){
            return Storage::disk($disk)->delete($photo->img_path);
        }
        return false;
    }


    public function getAlbums(){
        return Album::orderBy('album_name')->where('user_id', Auth::user()->id)->get();
    }

}
