<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    public function roles(){
        return $this->beLongsToMany(Role::class, 'role_permission');
    }
     public function users(){
        return $this->belongsToMany(User::class,'user_role');
     }
}
