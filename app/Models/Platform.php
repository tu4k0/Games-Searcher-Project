<?php

namespace App\Models;

use App\Constants\PlatformConstant;
use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Platform extends BaseModel
{
    use HasFactory;

    protected $table = 'platforms';
    protected $fillable = PlatformConstant::FILLABLE;
    protected $hidden = ['created_at', 'updated_at'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platforms', 'platform_id', 'game_id');
    }
}
