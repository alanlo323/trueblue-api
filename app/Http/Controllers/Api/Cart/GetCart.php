<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/v1/carts/{id}",
 *     operationId="cart.getCart",
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
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(
 *                         property="rowId",
 *                         type="string",
 *                         example="4c13f596efdd61467998d9100b0a0ca1",
 *                     ),
 *                     @OA\Property(
 *                         property="id",
 *                         type="string",
 *                         example="9ymo1knaAZ",
 *                     ),
 *                     @OA\Property(
 *                         property="name",
 *                         type="string",
 *                         example="iPad Mini 4",
 *                     ),
 *                     @OA\Property(
 *                         property="qty",
 *                         type="string",
 *                         example="1",
 *                     ),
 *                     @OA\Property(
 *                         property="price",
 *                         type="number",
 *                         example="100",
 *                     ),
 *                     @OA\Property(
 *                         property="tax",
 *                         type="number",
 *                         example="0",
 *                     ),
 *                     @OA\Property(
 *                         property="subtotal",
 *                         type="number",
 *                         example="100",
 *                     ),
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="subtotal",
 *                 type="number",
 *                 example="100.00",
 *             ),
 *         ),
 *     )
 * )
 */
class GetCart extends Controller
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

        if ($this->cache->get('cart:' . $cartId) != $request->user()->id) {
            abort(401);
        }

        $this->cache->put('cart:' . $cartId, $this->cache->get('cart:' . $cartId), 15);
        $this->cache->put('cart.' . $cartId, $this->cache->get('cart.' . $cartId), 15);

        return response()->json([
            'items' => $cart->content(),
            'subtotal' => $cart->subtotal(),
        ]);
    }
}
