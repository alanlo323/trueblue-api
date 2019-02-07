<?php

namespace App\Listeners;

use App\Models\AppSetting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardRegistrationBonus
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle($event)
    {
        $settings = AppSetting::fromKeys([
            'registraion_bonus_enable',
            'registraion_bonus_point'
        ]);

        $isEnabled = $settings->get('registraion_bonus_enable', false);
        $points = (int) $settings->get('registraion_bonus_point', 0);

        if ($isEnabled && $points > 0) {
            $event->user->increment('points', $points);
        }
    }
}
