<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location as LocationResource;
use App\Models\Region;

/**
 * @OA\Get(
 *     path="/v1/regions/{id}/locations",
 *     operationId="region.listLocations",
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
 *             @OA\Items(ref="#/components/schemas/Location"),
 *         )
 *     ),
 * )
 */
class ListLocations extends Controller
{
    public function __invoke($id)
    {
        $region = Region::with('locations')->findOrFail($id);

        return LocationResource::collection($region->locations);
    }
}
