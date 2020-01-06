<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumsRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            "name" => "required|unique:albums,album_name",
            "description" => "required",
            "album_thumb" => "required|image",
        ];
    }

    public function messages(){
        return [
            "name.required" => "Il nome è obbligatorio",
            "description.required" => "La descrizione è obbligatoria",
            "album_thumb.required" => "L'immagine è obbligatoria",
        ];
    }
}
