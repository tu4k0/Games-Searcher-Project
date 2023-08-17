<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'login' => ['required', 'string', 'min:8', 'max:255'],
            'email' => ['required', 'email', 'min:8', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:255']
        ];
    }
}
