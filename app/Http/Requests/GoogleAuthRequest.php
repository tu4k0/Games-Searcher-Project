<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validationData()
    {
        $googleAuthUser = Socialite::driver('google')->stateless()->user();
        $this->merge([
            "googleId" => $googleAuthUser->id,
            "googleName" => $googleAuthUser->name,
            "googleEmail" => $googleAuthUser->email
        ]);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "googleId" => ['required', 'numeric'],
            "googleName" => ['required', 'string'],
            "googleEmail" => ['required', 'email']
        ];
    }

    public function messages()
    {
        return [
            "*.required" => __('auth.google_auth_required')
        ];
    }
}
