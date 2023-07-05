<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostLogin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required!',
            'password.required' => 'Password is required!',
            'captcha.captcha' => __('Invalid captcha code.'),
        ];
    }
}
