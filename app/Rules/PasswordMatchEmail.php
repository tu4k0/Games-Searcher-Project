<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordMatchEmail implements Rule
{
    protected string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value)
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            return Hash::check($value, $user->password);
        }

        return $this->message();
    }

    public function message()
    {
        return __('auth.user');
    }
}
