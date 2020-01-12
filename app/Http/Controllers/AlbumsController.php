<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\AlbumsRequest;
use App\Http\Requests\AlbumsUpdateRequest;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use DB;
use Storage;

class AlbumsController extends Controller {

    public function index(Request $request){
        $sql = Album::orderByDesc("id")->withCount('photos');

        if($request->has("id")){
            $sql->where("id", $request->input("id"));
        }

        $sql->where('user_id', Auth::user()->id);

        if($request->has("album_name")){
            $sql->where("album_name" , "LIKE" , "%".$request->input("album_name")."%" );
        }
        $albums = $sql->paginate(env('IMG_PER_PAGE'));

        return view("albums.albums", ["albums" => $albums] );
    }

    public function delete(Album $album){
        $thumbnail = $album->album_thumb;
        $disk = config("filesystems.default");

        $res = $album->delete();

        if($res){
           if($thumbnail && Storage::disk($disk)->has($thumbnail)){
                Storage::disk($disk)->delete($thumbnail);
            }
        }

        return (string)$res;
    }


    public function create(){
        $album = new Album();
        return view("albums.createalbum", ["album"=> $album]);
    }

    public function save(AlbumsRequest $request){
        $album = new Album();
        $album->album_name = $request->input("name");
        $album->album_thumb = '';
        $album->description = $request->input("description");
        $album->user_id = $request->user()->id;

        $res = $album->save();

        if($res){
            $this->processFile($album->id, $request ,  $album);
            $album->save();
        }

        $name = $request->input("name");
        $message = $res ? "Album " . $name . " creato" : "Album ". $name . " non è stato creato";
        session()->flash('message' , $message);
        return redirect()->route('albums');
    }

    public function edit($id){
        $album = Album::find($id);
        return view("albums.edit" , ["album" => $album]);
    }

    public function store(AlbumsUpdateRequest $request, $id){
        $album = Album::find($id);
        $album->album_name = $request->input("name");
        $album->description = $request->input("description");
        $album->user_id = $request->user()->id;

        $this->processFile($id, $request, $album);

        $res = $album->save();
        $message = $res ? "Album ". $album->album_name ." è stato modificato" : "Operazione di modifica fallita";

        session()->flash("message" , $message);
        return redirect()->route("albums");
    }


    public function processFile($id, $request, $album){
        if(!$request->hasFile("album_thumb")){
            return false;
        }

        $file = $request->file("album_thumb");

        if($file->isValid()){
            $fileName = $id . "." . $file->extension();
            $album->album_thumb = $file->storeAs(env("ALBUM_THUMB_DIR"), $fileName);
        }else{
            return false;
        }
    }

    public function getImages(Album $album){
        $images = Photo::where("album_id", $album->id)->orderByDesc("updated_at")->paginate(env('IMG_PER_PAGE'));;
        return view('images.albumimages' , ["images"=>$images, "album"=>$album]);
    }

}
