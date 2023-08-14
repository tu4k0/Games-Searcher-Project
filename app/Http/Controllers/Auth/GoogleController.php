<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends BaseController
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handle()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $userInDB = $this->userRepository->findUserByEmail($user->email);

        if ($userInDB) {
            Auth::guard("user")->login($userInDB);

            return redirect(route('home'));
        } else {
            $newUser = $this->userRepository->createUser([
                "login" => $user->name,
                "email" => $user->email,
                "google_id" => $user->id
            ]);

            Auth::guard("user")->login($newUser);

            return redirect(route('home'));
        }
    }
}
