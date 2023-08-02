<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;


class GameController extends Controller
{
    public function getGameById(string $id)
    {
        return Game::findOrFail($id);
    }
}
