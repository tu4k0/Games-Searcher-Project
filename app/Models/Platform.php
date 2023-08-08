<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends BaseModel
{
    use HasFactory;

    protected $table = 'platforms';
    protected $fillable = ['id', 'abbreviation', 'name', 'category', 'generation', 'slug'];
    protected $hidden = ['created_at', 'updated_at'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platforms', 'platform_id', 'game_id');
    }
}
