<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ];
    }

    
    /**
     * Custom message for validation
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'email.required' => 'Please enter your email',
            'password.required' => 'Please enter password',
            'password.min'=>'Password must be 4 characters'
        ];
    }
}
