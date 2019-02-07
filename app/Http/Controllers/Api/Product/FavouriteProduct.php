<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Favourable;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/v1/products/{id}/favourite",
 *     operationId="product.favouriteProduct.add",
 *     tags={"Product"},
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
 *     )
 * )
 * @OA\Delete(
 *     path="/v1/products/{id}/favourite",
 *     operationId="product.favouriteProduct.remove",
 *     tags={"Product"},
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
 *     )
 * )
 */
class FavouriteProduct extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->isMethod('post')) {
            try {
                $product->favourites()->save(
                    tap(new Favourable(), function (Favourable $favourable) use ($request) {
                        $favourable->user()->associate($request->user());
                    })
                );
            } catch (\Throwable $e) {}
        } else {
            $product->favourites()->where('user_id', $request->user()->id)->delete();
        }

        return response()->json((object) [], $request->isMethod('post') ? 201 : 200);
    }
}
