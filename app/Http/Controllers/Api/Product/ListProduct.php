<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;

/**
 * @OA\Get(
 *     path="/v1/products",
 *     operationId="product.listProducts",
 *     tags={"Product"},
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
class ListProduct extends Controller
{
    public function __invoke()
    {
        return ProductResource::collection(
            Product::whereIsVariant(false)->get()
        );
    }
}
