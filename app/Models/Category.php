<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

/** @mixin \Eloquent */
class Category extends Model
{
    use SoftDeletes, NodeTrait;

    protected $fillable = ['name'];

    protected $dates = ['published_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
