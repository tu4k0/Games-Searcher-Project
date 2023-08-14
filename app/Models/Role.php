<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['id', 'name'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
