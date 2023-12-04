<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' =>'required|email|unique:admins,email,'.$this->id,
            'password' => 'nullable|confirmed|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required',
            'email.required' => 'The email is required',
            'email.email' => 'The email is not correct',
            'email.unique' => 'The email is already token',
            'password.confirmed' => 'The password confirmation does not match'
        ];
    }
}
