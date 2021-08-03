<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'modifier'
    ];

    function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class , 'user_group');
    }

    function boards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Board::class , 'board_id' );
    }
}
