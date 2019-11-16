<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use DB;

class AlbumsController extends Controller {

    public function index(Request $request){
        $sql = Album::orderByDesc("id");

        if($request->has("id")){
            $sql->where("id", $request->input("id"));
        }

        if($request->has("album_name")){
            $sql->where("album_name" , "LIKE" , "%".$request->input("album_name")."%" );
        }
        $albums = $sql->get();

        return view("albums.albums", ["albums" => $albums] );
    }

    public function delete($id){
        $album = Album::find($id)->delete();
        return (string)$album;
    }

    public function create(){
        return view("albums.createalbum");
    }

    public function save(){
        $album = new Album();
        $album->album_name = request()->input("name");
        $album->description = request()->input("description");
        $album->user_id = 1;

        $res = $album->save();

        $message = $res ? "Album ". $album->album_name ." è stato salvato" : "Operazione di salvataggio fallita";
        session()->flash("message",$message);
        return redirect()->route("albums");
    }

    public function edit($id){
        $album = Album::find($id);

        return view("albums.edit" , ["album" => $album]);
    }

    public function store(Request $request, $id){
        $album = Album::find($id);
        $album->album_name = $request->input("name");
        $album->description = $request->input("description");
        $res = $album->save();

        $message = $res ? "Album ". $album->album_name ." è stato modificato" : "Operazione di modifica fallita";

        session()->flash("message" , $message);
        return redirect()->route("albums");
    }


}
