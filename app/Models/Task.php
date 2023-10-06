<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['description', 'notify_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
