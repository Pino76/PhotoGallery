<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                            Rule::unique('users', 'email')->ignore($this->id, 'id')
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'=> ['required' , Rule::in(['user', 'admin'])]
        ];
    }

    public function messages(){
        return[
            'name.required' => 'Il campo nome è obbligatorio',
            'email.required' => 'Il campo email è obbligatorio',
            'email.unique' => 'Il campo email deve essere univoco',
            'role.required' => 'Il campo ruolo è obbligatorio'

        ];
    }


}
