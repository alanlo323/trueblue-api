<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Event extends Model
{
    protected $fillable = ['name', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function favourites()
    {
        return $this->morphMany(Favourable::class, 'favourable');
    }
}
