<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = "cards";
    protected $fillable = [
        'title',
        'content',
        'list_id',
        'location'
    ];
    use HasFactory;

    function listModel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ListModel::class , 'card_id');
    }

    function labels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Label::class , 'card_id');
    }

    function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class , 'cars_id');
    }

    function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class , 'user_card');
    }
}
