<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @mixin \Eloquent */
class LinkedSocialAccount extends Model
{
    const PROVIDER_FACEBOOK = 1;
    const PROVIDER_WECHAT = 2;

    protected $fillable = [
        'provider', 'provider_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    static function toProviderEnum($provider): ?int
    {
        return array_get([
            'facebook' => static::PROVIDER_FACEBOOK,
            'wechat' => static::PROVIDER_WECHAT,
        ], $provider);
    }
}
