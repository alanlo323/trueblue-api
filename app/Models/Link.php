<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Link extends Model
{
    protected $fillable = ['type', 'title', 'link'];

    public function linkable()
    {
        return $this->morphTo();
    }
}
