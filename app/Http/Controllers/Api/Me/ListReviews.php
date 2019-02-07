<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Review;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/me/reviews/products",
 *     operationId="me.listReviews",
 *     tags={"Me"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product"),
 *         )
 *     ),
 * )
 */
class ListReviews extends Controller
{
    public function __invoke(Request $request)
    {
        $favourites = Review::with('reviewable')
            ->where('user_id', $request->user()->id)
            ->get();

        return ProductResource::collection($favourites->map->reviewable);
    }
}
