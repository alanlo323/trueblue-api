<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\Region as RegionResource;
use App\Models\Region;

/**
 * @OA\Get(
 *     path="/v1/regions",
 *     operationId="region.listRegion",
 *     tags={"Region"},
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Region"),
 *         )
 *     ),
 * )
 */
class ListRegions extends Controller
{
    public function __invoke()
    {
        return RegionResource::collection(Region::published()->get());
    }
}
