<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News as NewsResource;
use App\Models\News;

/**
 * @OA\Get(
 *     path="/v1/news/{id}",
 *     operationId="news.showNews",
 *     tags={"News"},
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
 *         @OA\JsonContent(ref="#/components/schemas/News")
 *     ),
 * )
 */
class ShowNews extends Controller
{
    public function __invoke($id)
    {
        return new NewsResource(
            News::findOrFail($id)
        );
    }
}
