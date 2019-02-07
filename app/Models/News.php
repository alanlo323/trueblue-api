<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/** @mixin \Eloquent */
class News extends Model
{
    protected $fillable = ['title', 'content'];

    protected $dates = ['published_at', 'end_at'];

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    public function scopeWithin(Builder $query, $from, $to)
    {
        return $query
            ->whereDate('published_at', '>=', Carbon::parse($from))
            ->whereDate('ended_at', '<=', Carbon::parse($to));
    }
}
