<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Review extends Model
{
    protected $fillable = ['user_id', 'reviewable_id', 'reviewable_type', 'title', 'content', 'rating'];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query)
    {
        return $query->whereNotNull('approved_at');
    }
}
