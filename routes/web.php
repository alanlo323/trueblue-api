<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dev', function () {
//    Socialite::driver('facebook');
    dd(app());
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('oauth/{provider}/redirect', function ($provider) {
    return Socialite::driver($provider)
//        ->scopes([/*'email'*/'snsapi_login'])
//        ->redirectUrl(route('oauth.socialite.callback', [$provider]))
        ->redirect();
});

Route::any('oauth/{provider}/callback', function ($provider) {
    dd(Socialite::driver($provider)->user());
})->name('oauth.socialite.callback');
