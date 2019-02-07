<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @OA\Post(
 *     path="/v1/carts/{id}",
 *     operationId="cart.createCart",
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
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="id",
 *                 type="string",
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 type="number",
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *     )
 * )
 */
class AddItem extends Controller
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

        $data = $this->validate($request,[
            'id' => 'required|string',
            'quantity' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail(Hashids::decode($data['id'])[0]);

        $cart->add($product, $data['quantity']);

        return response()->json((object) [], 201);
    }
}
