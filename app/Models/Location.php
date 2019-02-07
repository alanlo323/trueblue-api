<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/** @mixin \Eloquent */
class Location extends Model
{
    use SoftDeletes, SpatialTrait;

    protected $fillable = [
        'name'
    ];

    protected $spatialFields = [
        'coord',
    ];

    protected $casts = [
        'opening_hours' => 'array',
    ];

    protected $appends = [
        'is_opening'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    public function getIsOpeningAttribute()
    {
        $now = Carbon::now();
        $todayOpeningHours = $this->opening_hours[$now->dayOfWeek] ?? [];

        return (int) ! empty($todayOpeningHours)
            && $now->between(
                Carbon::createFromFormat('H:i', $todayOpeningHours[0] ?? '00:00'),
                Carbon::createFromFormat('H:i', $todayOpeningHours[1] ?? '00:00')
            );
    }
}
