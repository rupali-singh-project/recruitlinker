<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_cat' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'userid' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }
}
