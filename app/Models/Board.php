<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = "boards";
    protected $fillable = [
        'title',
        'modifier'
    ];
    use HasFactory;
    protected $fillable = [
        'title',
        'modifier'
    ];



    function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ListModel::class , 'board_id');
    }

    function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class , 'user_board');
    }
}
