<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Review as ReviewResource;
use App\Models\Product;

/**
 * @OA\Get(
 *     path="/v1/products/{id}/reviews",
 *     operationId="product.listReviews",
 *     tags={"Product"},
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
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Review"),
 *         )
 *     ),
 * )
 */
class ListReviews extends Controller
{
    public function __invoke($id)
    {
        $product = Product::with(['reviews' => function ($query) {
            $query->approved();
        }, 'reviews.user'])->findOrFail($id);

        return ReviewResource::collection(
            $product->reviews
        );
    }
}
