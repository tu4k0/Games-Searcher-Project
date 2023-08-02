<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Game extends BaseModel
{
    use HasFactory;

    protected $table = 'games';
    protected $fillable = ['id', 'name', 'category_id', 'genre_id', 'rating', 'summary', 'first_release_date'];
    protected $hidden = ['created_at', 'updated_at'];
}
