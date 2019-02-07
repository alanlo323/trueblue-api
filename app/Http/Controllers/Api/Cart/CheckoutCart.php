<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;


class CheckoutCart extends Controller
{
    /** @var CacheManager */
    protected $cache;

    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(Request $request, $cartId)
    {
        $cart = Cart::instance($cartId);
        $user = $request->user();

        if ($this->cache->get('cart:' . $cartId) != $user->id) {
            abort(401);
        }

        if ($cart->content()->isEmpty()) {
            abort(422, 'cart is empty');
        }

        $total = $cart->total();

        if ($user->points < $total) {
            abort(422, 'point is not enough');
        }

        $items = $cart->content()->map(function ($item) {
            return $item->model;
        });

        $items->filter(function ($item) {
            return $item->has_stock == true && true;
        });

        return response()->json((object) []);
    }
}
