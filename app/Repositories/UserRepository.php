<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function createUser(array $userData): mixed
    {
        return DB::transaction(function () use ($userData) {
            return $this->create($userData);
        });
    }
}
