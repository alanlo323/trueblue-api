<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\News as NewsResource;
use App\Models\News;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @OA\Get(
 *     path="/v1/regions/{id}/news",
 *     operationId="region.listNews",
 *     tags={"Region"},
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
 *             @OA\Items(ref="#/components/schemas/News"),
 *         )
 *     ),
 * )
 */
class ListNews extends Controller
{
    public function __invoke($id)
    {
        Region::findOrFail($id);

        $news = QueryBuilder::for(
            News::with('regions')
                ->whereHas('regions', function (Builder $query) use ($id) {
                    $query->where('region_id', $id);
                })
                ->orDoesntHave('regions')
                ->orderByDesc('published_at')
        )->allowedFilters(Filter::scope('within'))->get();

        return NewsResource::collection($news);
    }
}
