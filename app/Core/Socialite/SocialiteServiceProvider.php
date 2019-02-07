<?php

namespace App\Core\Socialite;

use App\Core\Socialite\Two\WechatProvider;
use Illuminate\Contracts\Foundation\Application;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteServiceProvider as ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->make(Factory::class)
            ->extend('wechat', function (Application $app): WechatProvider {
                $config = $app['config']['services.wechat'];

                return $app->make(Factory::class)->buildProvider(
                    WechatProvider::class, $config
                );
            });
    }
}
