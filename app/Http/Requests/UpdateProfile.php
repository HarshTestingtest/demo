<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfile extends FormRequest
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
        $id = Auth::user()->id;

        return [
            'name' => 'required',
            'username' => 'required|unique:users,username,'. $id,
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,'.$id,
            'email' => 'required|email|unique:users,email,'. $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'mobile_no.required' => 'Mobile number is required!',
            'username.required' => 'Username is required!',
        ];
    }
}
