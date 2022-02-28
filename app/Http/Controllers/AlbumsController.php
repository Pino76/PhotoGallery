<?php

namespace App\Http\Controllers;

use App\Events\NewAlbumCreated;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Auth;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected function resourceAbilityMap()
    {
        return [
            'getImages'=>'getImages'
        ];
    }


    public function __construct(){
        $this->authorizeResource(Album::class);
      ###  $this->middleware('auth')->except('index');
    }

    public function index(Request $request) {

        $queryBuilder = Album::orderByDesc('id')->withCount('photos');

        $queryBuilder->where('user_id', Auth::user()->id);

        if($request->has("id")){
            $queryBuilder->where('id', $request->input("id"));
        }

        if($request->has("album_name")){
            $queryBuilder->where('album_name', 'like', $request->input('album_name') . '%');
        }

        if($request->has("category_id")){
            $queryBuilder->whereHas('categories', function ($q) use ($request) {
                return $q->where("category_id", $request->category_id);
            });
        }

        $albums = $queryBuilder->paginate( env('IMAGE_PER_PAGE',10));

        return view('albums.albums' , ['albums' => $albums]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $album = new Album();
        $category = Category::orderBy('category_name')->get();
        $selectedCategories = [];
        return view('albums.createalbum', [
            "album" => $album,
            "category"=>$category,
            "selectedCategories" => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request) {
       # $this->authorize(Album::class);
        $album = new Album();
        $album->album_name = $request->input('album_name');
        $album->description = $request->input('description');
        $album->user_id = Auth::id();
        $album->album_thumb = '';

        $res = $album->save();

        if($res){

            event(new NewAlbumCreated($album));

            if($request->has('categories')){
                $album->categories()->attach($request->input('categories')); #Inserisce nuove categorie
            }
            if($this->processFile($album->id, $request,$album)){
                $album->save();
            }
        }

        $message = "Album " . $album->album_name;
        $message.= $res ? " creato" : " non è stato creato";

        session()->flash('message' , $message);

        return redirect()->route('albums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {

       # if($album->user_id == Auth::id()){
            return $album;
        #}
        #abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album) {

       # $this->authorize($album);

       /*if(Gate::denies('manage-album', $album)){
            abort(401);
        }*/

        /*if($album->user_id != Auth::id()){
            abort(404);
        }*/
        $category = Category::orderBy('category_name')->get();
        $selectedCategories = $album->categories()->pluck('category_id')->toArray();
        #pluck prende solo quel campo
        return view("albums.editalbum", [
            "album" => $album,
            "category" => $category ,
            "selectedCategories" => $selectedCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, $id) {

        $album = Album::find($id);

      #  $this->authorize($album);

        /*if(Gate::denies('manage-album', $album)){
            abort(401);
        }*/

        $album->album_name = $request->input('album_name');
        $album->description = $request->input('description');
        $album->user_id = Auth::id();

        if($request->has('categories')){
            $album->categories()->sync($request->input('categories'));
            #sync se ci sono i valori li lascia e se ci sono nuovi valori li aggiorna
        }

        $this->processFile($id, $request, $album);

        $res = $album->save();

        $message = "Album " . $album->album_name;
        $message.= $res ? " è stato salvato" : " non è stato salvato";

        session()->flash('message' , $message);

        return redirect()->route('albums.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album) {

    /*    if(Gate::denies('manage-album', $album)){
            abort(401);
        }*/

        $thumbnail = $album->album_thumb;
        $res = $album->delete();

        if($res && $thumbnail && Storage::exists($thumbnail)){
            Storage::delete($thumbnail);
        }
        if(\request()->ajax()){
            return "".$res;
        }else{
            return redirect()->route('albums.index');
        }

    }


    public function processFile($id, Request $request,  &$album):bool
    {
        if (!$request->hasFile('album_thumb')) {
            return false;
        }

        $file = $request->file('album_thumb');

        if(!$file->isValid()){
            return false;
        }


        $filename = $id . "." . $file->extension();
        $file->storeAs(env('ALBUM_THUMB_DIR'), $filename);

        $album->album_thumb = env('ALBUM_THUMB_DIR').$filename;

        return true;
    }

    public function getImages(Album $album){

        $images =  Photo::whereAlbumId($album->id)->latest()->paginate(10);
        return view('images.albumimages', [
            'album'=> $album,
            'images'=> $images
        ]);
    }
}
