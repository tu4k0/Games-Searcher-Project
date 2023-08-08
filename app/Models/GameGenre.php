<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameGenre extends BaseModel
{
    use HasFactory;

    protected $table = 'game_genres';
    protected $fillable = ['id', 'game_id', 'genre_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
