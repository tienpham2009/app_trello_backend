<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = "boards";
    protected $fillable = [
        'id',
        'title',
        'modifier',
        'group_id'
    ];
    use HasFactory;



    function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ListModel::class , 'board_id');
    }

    function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class , 'user_board');
    }
}
