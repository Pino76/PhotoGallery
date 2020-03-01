<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
class Album extends Model{

    protected $fillable = ["album_name" , "description" , "user_id"];

    public function getPathAttribute(){
        $url = $this->album_thumb;
        if(stristr($this->album_thumb , "http")=== false){
            $url = "storage/".$this->album_thumb;
        }
        return $url;
    }

    #un album ha tante foto
    public function photos(){
        return $this->hasMany(Photo::class, "album_id", "id");
    }

    #un album appartiene ad un utente
    public function user(){
        return $this->belongsTo(User::class);
    }

    #un album appartiene a tante categorie
    public function categories(){
        return $this->belongsToMany(AlbumCategory::class , 'album_category' , 'album_id', 'category_id')
            ->withTimestamps();
    }

}
