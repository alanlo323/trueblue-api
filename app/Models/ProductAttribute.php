<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class ProductAttribute extends Model
{
    protected $fillable = ['name', 'options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
