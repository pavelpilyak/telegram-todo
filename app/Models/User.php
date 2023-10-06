<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['telegram_user_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
