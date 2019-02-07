<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/v1/carts",
 *     operationId="cart.createCart",
 *     tags={"Cart"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=201,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="identifier",
 *                 type="string",
 *                 example="nA3RdgxGRrA4HvEeKcLARNfmunAewf6R",
 *             ),
 *         )
 *     )
 * )
 */
class CreateCart extends Controller
{
    /** @var CacheManager */
    protected $cache;

    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(Request $request)
    {
        do {
            $identifier = str_random(32);
        } while(Cart::instance($identifier)->content()->isNotEmpty() && ! $this->cache->has('cart' . $identifier));

        $this->cache->put('cart:' . $identifier, $request->user()->id, 15);

        return response()->json(compact('identifier'));
    }
}
