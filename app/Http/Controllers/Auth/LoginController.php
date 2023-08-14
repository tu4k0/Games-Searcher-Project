<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginUser(LoginUserRequest $request)
    {
        $userLoginValidated = $request->validated();
        $user = $this->userRepository->findUserByEmail($userLoginValidated["email"]);

        if ($user) {
            if (Hash::check($userLoginValidated["password"], $user->password)) {
                return redirect(route('home'));
            }
            return redirect(route('login'))->withErrors(["userPassword" => "Password is incorrect. Try again"]);
        }

        return redirect(route('login'))->withErrors(["user" => "User not found. Try again"]);
    }
}
