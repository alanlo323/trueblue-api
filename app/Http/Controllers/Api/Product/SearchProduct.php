<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @OA\Get(
 *     path="/v1/products/search",
 *     operationId="product.searchProduct",
 *     tags={"Product"},
 *     @OA\Parameter(
 *         name="filter[name]",
 *         in="query",
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
class SearchProduct extends Controller
{
    public function __invoke(Request $request)
    {
        return ProductResource::collection(
            QueryBuilder::for(Product::whereIsVariant(false))
                ->allowedFilters('name')
                ->get()
        );
    }
}
