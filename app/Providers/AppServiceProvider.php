<?php

namespace App\Providers;

use Adaojunior\Passport\SocialUserResolverInterface;
use App\Core\Passport\SocialUserResolver;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'location' => \App\Models\Location::class,
            'news' => \App\Models\News::class,
            'product' => \App\Models\Product::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SocialUserResolverInterface::class, SocialUserResolver::class);

        $this->app->when(Cart::class)->needs(SessionManager::class)->give(function () {
            return new class extends SessionManager
            {
                public function __construct()
                {
                    parent::__construct($this->app);
                }

                public function put($name, $value)
                {
                    return cache()->put($name, $value, 15);
                }

                public function remove($name)
                {
                    return cache()->forget($name);
                }

                public function __call($name, $arguments)
                {
                    return cache()->{$name}(...$arguments);
                }
            };
        });
    }
}
