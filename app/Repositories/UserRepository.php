<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAllUsers()
    {
        return User::lazy(100);
    }

    public function findUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function findUserByEmail(string $email)
    {
        return User::where("email", $email)->first();
    }

    public function findUserByGoogleId(string $google_id)
    {
        return User::where('google_id', $google_id)->first();
    }

    public function deleteUser(int $id)
    {
        User::destroy($id);
    }

    public function createUser(array $userData)
    {
        $user = new User;

        $user->login = $userData["login"];
        $user->email = $userData["email"];
        $user->password = array_key_exists("password", $userData) ? Hash::make($userData["password"]) : null;
        $user->role_id = 1;
        $user->google_id = array_key_exists("google_id", $userData) ? $userData["google_id"] : null;

        $user->save();

        return $user;
    }

    public function updateUser(int $id, array $userUpdatedData)
    {
        return User::whereId($id)->update($userUpdatedData);
    }
}
