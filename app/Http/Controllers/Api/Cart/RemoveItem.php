<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;

/**
 * @OA\Delete(
 *     path="/v1/carts/{id}/{itemId}",
 *     operationId="cart.updateItem",
 *     tags={"Cart"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="itemId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *     )
 * )
 */
class RemoveItem extends Controller
{
    /** @var CacheManager */
    protected $cache;

    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(Request $request, $cartId, $rowId)
    {
        $cart = Cart::instance($cartId);

        if ($this->cache->get('cart:' . $cartId) != $request->user()->id) {
            abort(401);
        }

        $this->cache->put('cart:' . $cartId, $this->cache->get('cart:' . $cartId), 15);
        $this->cache->put('cart.' . $cartId, $this->cache->get('cart.' . $cartId), 15);

        $cart->remove($rowId);

        return response()->json((object) [], 200);
    }
}
