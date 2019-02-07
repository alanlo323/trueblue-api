<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/v1/products/{id}/reviews",
 *     operationId="product.createReview",
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
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="title",
 *                 type="string",
 *             ),
 *             @OA\Property(
 *                 property="content",
 *                 type="string",
 *             ),
 *             @OA\Property(
 *                 property="rating",
 *                 type="number",
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *     )
 * )
 */
class CreateReview extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $this->validate($request, [
            'title' => 'string',
            'content' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5'
        ]);

        $product->reviews()->save(
            tap(new Review($data), function (Review $review) use ($request) {
                $review->user()->associate($request->user());
            })
        );

        return response()->json((object) [], 201);
    }
}
