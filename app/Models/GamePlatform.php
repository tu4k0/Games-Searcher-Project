<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlatform extends BaseModel
{
    use HasFactory;

    protected $table = 'game_platforms';
    protected $fillable = ['id', 'game_id', 'platform_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
