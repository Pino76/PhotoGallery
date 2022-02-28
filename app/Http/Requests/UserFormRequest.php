<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = isset($this->user->id) ? $this->user->id : 0;
        $emailRule = $id ? Rule::unique('users')->ignore($id) : Rule::unique('users');
        return [
            'name'=>'required|string|max:255',
            'email'=>[
                'required','string','email','max:255',
                $emailRule,
            ],
            'user_role' => Rule::in(['user', 'admin']),
        ];
    }

    public function messages(){
        $messages = [
            'name.required' => 'Il campo nome è obbligatorio',
            'name.unique' => 'Il campo nome deve essere univoco',
            'email.required' => 'Il campo email deve essere univoco',
            'user_role.required' => 'Il campo ruolo è obbligatorio'
        ];
        return $messages;
    }
}
