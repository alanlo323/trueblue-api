<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class AppSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public function getValueAttribute($value)
    {
        if (in_array(strtolower($value), ['true', 'false'])) {
            return strtolower($value) === 'true';
        }

        return $value;
    }

    static public function fromKeys($keys = []) {
        return static::whereIn('key', array_wrap($keys))
            ->get()
            ->pluck('value', 'key');
    }
}
