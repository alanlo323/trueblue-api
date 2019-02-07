<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location as LocationResource;
use App\Models\Region;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/v1/regions/{id}/locations/nearest",
 *     operationId="region.listNearestLocations",
 *     tags={"Region"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="lat",
 *         in="query",
 *         required=true,
 *         @OA\Schema(
 *             type="number"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="lng",
 *         in="query",
 *         required=true,
 *         @OA\Schema(
 *             type="number"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         @OA\Schema(
 *             type="string",
 *             enum={"isOpening"},
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Location"),
 *         )
 *     ),
 * )
 */
class ListNearestLocations extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $data = $this->validate($request, [
            'lat' => 'required',
            'lng' => 'required',
            'sort' => 'string|in:isOpening'
        ]);

        $region = Region::with(['locations' => function (HasMany $query) use ($data) {
            $query->distanceValue('coord', new Point($data['lat'], $data['lng']))
                ->orderBy('distance');
        }])->findOrFail($id);

        return LocationResource::collection(
            $region->locations
                ->when(array_get($data, 'sort') === 'isOpening', function ($locations) {
                    return $locations->sortByDesc('is_opening');
                })
        );
    }
}
