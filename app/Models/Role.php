<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{   protected $table = "roles";
    use HasFactory;

    function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return  $this->belongsToMany(User::class , 'user_board');
    }

    function boards(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return  $this->belongsToMany(User::class , 'user_board');
    }
}
