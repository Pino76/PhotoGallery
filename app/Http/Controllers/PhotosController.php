<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{

    protected $rules = [
        'name' => 'bail|required',
        'description' => 'bail|required',
        'album_id' => 'bail|required|integer|exists:albums,id',
        'img_path' => 'bail|required|image'
    ];



    protected $messages = [
        'name.required' => 'Il campo nome è obbligatorio',
        'description.required' => 'Il campo descrizione è obbligatorio',
        'album_id.required' => 'Il campo album è obbligatorio',
        'album_id.integer' => "Il valore dell'album deve essere numerico" ,
        'img_path.required' => 'Il campo immagine è obbligatorio',
        'img_path.image' => 'Il campo immagine deve essere una immagine(jpeg,png,gif)'
    ];

    public function __construct()
    {
        $this->authorizeResource(Photo::class);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $album = $request->album_id ? Album::findOrFail($request->album_id) : new Album();
        $photo = new Photo();
        $albumList = $this->getAlbums();
        return view('images.editimage' , [
            'album' => $album,
            'photo' => $photo,
            'albumList' => $albumList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->messages);
        $photo = new Photo();
        $photo->name = $request->name;
        $photo->description = $request->description;
        $photo->album_id = $request->album_id;
        $this->processFile($photo);
        $photo->save();

        return redirect(route('albums.images',  $photo->album_id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $album = $photo->album;
        $albumList = $this->getAlbums();
        return view('images.editimage', ['album'=>$album , 'photo' => $photo , 'albumList' => $albumList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        unset($this->rules['img_path']);
        $this->validate($request, $this->rules, $this->messages);

        $this->processFile($photo);
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album_id');
        $res = $photo->save();

        $message = $res ? "Foto ".$photo->name ." salvata correttamente" : " Problemi con il salvataggio";
        session()->flash('message', $message);
        return redirect()->route('albums.images', $photo->album_id);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();

        if($res){
            $this->deleteFile($photo->id);
        }
        return "".$res;
    }


    public function processFile(Photo $photo, Request $request=null):bool
    {

        if(!$request){
            $request = request();
        }

        if (!$request->hasFile('img_path')) {
            return false;
        }

        $file = $request->file('img_path');

        if(!$file->isValid()){
            return false;
        }

        $imgName = preg_replace('@[a-z0-9]i@', '_', $photo->name);

        $filename = $imgName . "." . $file->extension();

        $file->storeAs(env('IMG_DIR')."/".$photo->album_id, $filename);

        $photo->img_path = env('IMG_DIR').$photo->album_id."/".$filename;

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
        $album = Album::where("user_id" , Auth::id())->orderBy('album_name')->get();
        return $album;
    }

}
