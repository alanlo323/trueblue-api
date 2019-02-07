<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourable extends Model
{
    protected $fillable = ['user_id', 'favourable_id', 'favourable_type'];

    public function favourable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'favourable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
