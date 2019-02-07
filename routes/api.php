<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::bind('id', function ($id) {
    if (Route::current()->getController() instanceof VerificationController) {
        return $id;
    }

    if(empty($id = Hashids::decode($id))) {
        return '';
    }

    return array_first($id);
});

Route::get('/qrcode/text/{content}', function (Request $request, $content) {
    return response(
        \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->size(256)
            ->margin(0)
            ->generate($content)
    )->header('Content-type','image/png');
})->name('qrcode');

Route::prefix('v1')->group(function () {
    Route::post('/auth/password/register', \App\Http\Controllers\Api\Auth\Register::class);
    Route::post('/auth/password/forgot', \App\Http\Controllers\Api\Auth\ForgotPassword::class);
    Route::post('/auth/password/reset', \App\Http\Controllers\Api\Auth\ResetPassword::class);

    Route::get('/regions', \App\Http\Controllers\Api\Region\ListRegions::class);
    Route::get('/regions/{id}', \App\Http\Controllers\Api\Region\ShowRegion::class);
    Route::get('/regions/{id}/locations', \App\Http\Controllers\Api\Region\ListLocations::class);
    Route::get('/regions/{id}/locations/nearest', \App\Http\Controllers\Api\Region\ListNearestLocations::class);
    Route::get('/regions/{id}/news', \App\Http\Controllers\Api\Region\ListNews::class);

    Route::get('/categories/{id?}', \App\Http\Controllers\Api\Category\ListCategory::class);
    Route::get('/categories/{id}/products', \App\Http\Controllers\Api\Category\ListProducts::class);

    Route::get('/products', \App\Http\Controllers\Api\Product\ListProduct::class);
    Route::get('/products/search', \App\Http\Controllers\Api\Product\SearchProduct::class);
    Route::get('/products/{id}', \App\Http\Controllers\Api\Product\ShowProduct::class);
    Route::get('/products/{id}/reviews', \App\Http\Controllers\Api\Product\ListReviews::class);

    Route::get('/news/{id}', \App\Http\Controllers\Api\News\ShowNews::class);

    Route::get('/i18n/{locale}/{group?}', \App\Http\Controllers\Api\GetI18n::class);

    Route::get('/locations/{id}', \App\Http\Controllers\Api\Location\ShowLocation::class);

    Route::middleware('auth:api')->group(function (){
        Route::post('/carts', \App\Http\Controllers\Api\Cart\CreateCart::class);
        Route::get('/carts/{cartId}', \App\Http\Controllers\Api\Cart\GetCart::class);
        Route::delete('/carts/{cartId}', \App\Http\Controllers\Api\Cart\EmptyCart::class);
        Route::post('/carts/{cartId}', \App\Http\Controllers\Api\Cart\AddItem::class);
        Route::put('/carts/{cartId}/{rowId}', \App\Http\Controllers\Api\Cart\UpdateItem::class);
        Route::delete('/carts/{cartId}/{rowId}', \App\Http\Controllers\Api\Cart\RemoveItem::class);

        Route::get('/me', \App\Http\Controllers\Api\Me\ShowMe::class);
        Route::put('/me', \App\Http\Controllers\Api\Me\UpdateMe::class);

        Route::get('/me/favourites/products', \App\Http\Controllers\Api\Me\ListFavourites::class);
        Route::get('/me/reviews/products', \App\Http\Controllers\Api\Me\ListReviews::class);

        Route::post('/products/{id}/favourite', \App\Http\Controllers\Api\Product\FavouriteProduct::class);
        Route::delete('/products/{id}/favourite', \App\Http\Controllers\Api\Product\FavouriteProduct::class);

        Route::post('/products/{id}/reviews', \App\Http\Controllers\Api\Product\CreateReview::class);
    });
});

Route::fallback(function () {
    abort(404);
});

Route::get('/dev', function (){
//    \App\Models\ProductAttribute::create([
//        'name' => 'colors',
//        'options' => [
//            '灰色', '銀色', '金色'
//        ]
//    ]);

//    \App\Models\Product::create([
//        'name' => 'iPad Mini 4'
//    ]);

    \App\Models\Product::find(1)
        ->categories()->attach([
            2, 3
        ]);

//    \App\Models\Product::find(2)
//        ->attributes()->attach([
//            1 => [
//                'options' => [],
//                'value' => '灰色'
//            ]
//        ]);


//    trans()->load('*', 'validation', 'en');
//    dd(trans(), get_class(trans()));

//    LanguageLine::create([
//        'group' => 'ui',
//        'key' => 'retry',
//        'text' => ['en' => 'retry', 'zh-HK' => '重試'],
//    ]);

//    $diu = \App\Models\AppSetting::fromKeys(['registraion_bonus_enable', 'registraion_bonus_point']);
//
//    dd($diu);

//    \App\Models\Location::find(1)->links()->create([
//        'type' => 'instagram',
//        'link' => 'https://www.instagram.com/nike/'
//    ]);

//    (new \App\Models\Category())->forceFill([
//        'name' => '智能電話',
//        'parent_id' => 2
//    ])->save();

//    $loc = (new \App\Models\Location)
//        ->forceFill([
//            'name' => '銅鑼灣廣場一期',
//            'coord' => new \Grimzy\LaravelMysqlSpatial\Types\Point(22.280212,114.180363),
//            'opening_hours' => [
//                5 => ['00:00', '23:59']
//            ],
//            'published_at' => \Illuminate\Support\Carbon::now()
//        ]);
//
//    $loc->region()->associate(\App\Models\Region::first());
//
//    $loc->save();
//    dd(
//        \App\Models\Location::distanceValue('coord', new \Grimzy\LaravelMysqlSpatial\Types\Point(
//            //22.28496,114.1371468
//            22.2808824,114.1851003
//        ))->get()
//    );
});
