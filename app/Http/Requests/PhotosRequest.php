<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotosRequest extends FormRequest
{
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
            'album_id' => 'required|integer|exists:albums,id',
            'name' => 'required',
            'description' => 'required',
            'img_path' => "required|image",
        ];
    }

    public function messages(){
        return [
            'album_id.required' => 'Il campo Album è obbligatorio',
            'description.required' => 'Il campo Descrizione è obbligatorio',
            'name.required' => 'Il campo Nome è obbligatorio',
            'img_path.required' => 'Il campo Immagine è obbligatorio'
        ];
    }
}
