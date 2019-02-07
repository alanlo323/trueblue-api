<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('/regions', 'RegionController');
    $router->resource('/locations', 'LocationController');
    $router->resource('/news', 'NewsController');
    $router->resource('/products/categories', 'ProductCategoryController');
    $router->resource('/app/settings', 'AppSettingController');
    $router->resource('/users', 'UserController');
    $router->resource('/orders', 'OrderController');
    $router->resource('/reviews', 'ReviewController');
    $router->resource('/products', 'ProductController');
    $router->resource('/rewards', 'RewardController');
    $router->resource('/events', 'EventController');
});
