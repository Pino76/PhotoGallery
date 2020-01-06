<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotosUpdateRequest extends FormRequest
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
            'album_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(){
        return [
            'album_id.required' => 'Il campo Album è obbligatorio',
            'name.required' => 'Il campo Nome della foto è obbligatorio',
            'description.required' => 'Il campo Descrizione è obbligatorio',
        ];
    }
}
