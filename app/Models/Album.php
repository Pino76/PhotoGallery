<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model{

    public function getPathAttribute(){
        $url = $this->album_thumb;
        if(stristr($this->album_thumb , "http")=== false){
            $url = "storage/".$this->album_thumb;
        }
        return $url;
    }

}
