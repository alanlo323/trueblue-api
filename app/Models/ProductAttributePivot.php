<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAttributePivot extends Pivot
{
    protected $fillable = ['options', 'value'];

    protected $casts = [
        'options' => 'array',
    ];
}
