<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;

/**
 * @OA\Get(
 *     path="/v1/products/{id}",
 *     operationId="product.showProduct",
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
 *             type="object",
 *             allOf={
 *                 @OA\Schema(ref="#/components/schemas/Product"),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(
 *                         property="categories",
 *                         type="array",
 *                         @OA\Items(ref="#/components/schemas/Category"),
 *                     ),
 *                     @OA\Property(
 *                         property="attributes",
 *                         type="array",
 *                         @OA\Items(ref="#/components/schemas/ProductAttribute"),
 *                     ),
 *                     @OA\Property(
 *                         property="variants",
 *                         type="array",
 *                         @OA\Items(ref="#/components/schemas/Product"),
 *                     ),
 *                 ),
 *             }
 *         )
 *     ),
 * )
 */
class ShowProduct extends Controller
{
    public function __invoke($id)
    {
        return new ProductResource(
            Product::with('attributes','categories', 'variants', 'variants.attributes')
                ->findOrFail($id)
        );
    }
}
