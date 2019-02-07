<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;

/**
 * @OA\Get(
 *     path="/v1/categories",
 *     operationId="category.listCategories",
 *     tags={"Category"},
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Category"),
 *         )
 *     ),
 * )
 * @OA\Get(
 *     path="/v1/categories/{id}",
 *     operationId="category.showCategory",
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
 *         @OA\JsonContent(ref="#/components/schemas/Category"))
 *     ),
 * )
 */
class ListCategory extends Controller
{
    public function __invoke($id = null)
    {
        $category = Category::with('children');

        if (empty($id)) {
            return CategoryResource::collection(
                $category->whereIsRoot()->get()
            );
        }

        return new CategoryResource(
            $category->findOrFail($id)
        );
    }
}
