<?php

namespace App\Models;

use App\Constants\GenreConstant;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends BaseModel
{
    use HasFactory;

    protected $table = 'genres';
    protected $fillable = GenreConstant::FILLABLE;
    protected $hidden = ['created_at', 'updated_at'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_genres', 'genre_id', 'game_id');
    }
}
