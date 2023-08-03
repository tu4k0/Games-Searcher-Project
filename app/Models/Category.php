<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['id', 'name'];

    public function games()
    {
        return $this->hasMany(Game::class, 'category_id', 'id');
    }
}
