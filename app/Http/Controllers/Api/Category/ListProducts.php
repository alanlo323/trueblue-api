<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Category;

/**
 * @OA\Get(
 *     path="/v1/categories/{id}/products",
 *     operationId="category.listProducts",
 *     tags={"Category"},
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
 *             @OA\Items(ref="#/components/schemas/Product"),
 *         )
 *     ),
 * )
 */
class ListProducts extends Controller
{
    public function __invoke($id)
    {
        $category = Category::with(['products' => function ($query) {
            $query->whereIsVariant(false);
        }])->findOrFail($id);

        return ProductResource::collection(
            $category->products
        );
    }
}
