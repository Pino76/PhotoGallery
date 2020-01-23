<?php

namespace App\Http\Requests;
use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Gate;

class AlbumsUpdateRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        $album = Album::find($this->id);
        if(Gate::denies('manage-album', $album)){
            return false;
        }
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
        ];
    }

    public function messages(){
        return [
            "name.required" => "Il nome è obbligatorio",
            "description.required" => "La descrizione è obbligatoria",
        ];
    }

}
