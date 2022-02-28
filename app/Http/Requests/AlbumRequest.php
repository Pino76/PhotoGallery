<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

       /* $album = Album::findOrFail($this->route()->album);
        if(Gate::denies('manage-album', $album)){
            return false;
        }else{
            return true;
        }*/

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route()->album;

        $ret = [
            'album_name'=>['required'],
            'description'=>['required']
        ];

        if($id){
            $ret['album_name'][] = Rule::unique('albums','album_name')->ignore($id);
        }else{
            $ret['album_thumb'] = 'required|image';
            $ret['album_name'][] = Rule::unique('albums','album_name');
        }

        return $ret;
    }


    public function messages()
    {
        $messages = [
            'album_name.required' => 'Il campo album name  è obbligatorio',
            'album_name.unique' => 'Il campo album name  esiste già',
            'description.required' => 'Il campo Descrizione è obbligatorio',
            'album_thumb.required' => 'Il campo Immagine è obbligatorio'

        ];
        return $messages;
    }

}
