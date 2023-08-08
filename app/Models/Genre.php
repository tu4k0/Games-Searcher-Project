<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends BaseModel
{
    use HasFactory;

    protected $table = 'genres';
    protected $fillable = ['id', 'name', 'slug'];
    protected $hidden = ['created_at', 'updated_at'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_genres', 'genre_id', 'game_id');
    }
}
