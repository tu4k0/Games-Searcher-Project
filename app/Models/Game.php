<?php

namespace App\Models;

use App\Constants\GameConstant;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends BaseModel
{
    use HasFactory;

    protected $table = 'games';
    protected $fillable = GameConstant::FILLABLE;
    protected $hidden = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'game_genres', 'game_id', 'genre_id');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'game_platforms', 'game_id', 'platform_id');
    }
}
