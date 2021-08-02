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



    function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ListModel::class , 'board_id');
    }

    function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
