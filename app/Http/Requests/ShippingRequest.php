<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'id' => 'required|exists:settings',
            'value' => 'required',
            'plain_value' =>'nullable|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'id.exists' => 'This shipping method not found',
            'email.value' => 'Please insert the correct shipping method',
            'plain_value' => 'Please insert the correct value'
        ];
    }
}
