<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleAuthRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginUser(LoginUserRequest $request)
    {
        $userLoginValidated = $request->validated();
        $user = User::where("email", $userLoginValidated["email"])->first();
        Auth::guard("user")->login($user);

        return redirect(route('home'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerUser(UserRepository $userRepository, RegisterUserRequest $request)
    {
        $userRegisterValidated = $request->validated();
        $user = $userRepository->createUser($userRegisterValidated);

        if ($user) {
            Auth::guard("user")->login($user);
        }

        return redirect(route('home'));
    }

    public function redirectToGoogleAuthForm()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function authUserViaGoogle(GoogleAuthRequest $googleAuthRequest, UserRepository $userRepository): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::where("email", $googleAuthRequest->input("googleEmail"))->first();
        if (!$user) {
            $user = $userRepository->createUser([
                "login" => $googleAuthRequest->input("googleName"),
                "email" => $googleAuthRequest->input("googleEmail"),
                "google_id" => $googleAuthRequest->input("googleId")
            ]);
        }
        Auth::guard("user")->login($user);

        return redirect(route('home'));
    }
}
