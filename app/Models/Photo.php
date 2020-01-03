<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
class Photo extends Model{


    public function  getImgPathAttribute($value){
        if(stristr($value ,'http') === false){
            $value = '/storage/'.$value;
        }
        return $value;
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = strtoupper($value);
    }

    public function album(){
        #$this->belongsTo(Album::class, 'album_id', 'id');
        return $this->belongsTo(Album::class);
        #una foto appartiene ad un album
    }


}
