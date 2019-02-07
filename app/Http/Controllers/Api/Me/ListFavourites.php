<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Favourable;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/me/favourites/products",
 *     operationId="me.listFavourites",
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
class ListFavourites extends Controller
{
    public function __invoke(Request $request)
    {
        $favourites = Favourable::with('favourable')
            ->where('user_id', $request->user()->id)
            ->get();

        return ProductResource::collection($favourites->map->favourable);
    }
}
