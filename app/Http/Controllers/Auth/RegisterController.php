<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $userRegisterValidated = $request->validated();
        $user = $this->userRepository->createUser($userRegisterValidated);

        if ($user) {
            Auth::guard("user")->login($user);
        }

        return redirect(route('home'));
    }
}
