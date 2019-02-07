<?php

namespace App\Http\Controllers\Api\Region;

use App\Http\Controllers\Controller;
use App\Http\Resources\Region as RegionResource;
use App\Models\Region;

/**
 * @OA\Get(
 *     path="/v1/regions/{id}",
 *     operationId="region.showRegion",
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
 *         @OA\JsonContent(ref="#/components/schemas/Region")
 *     ),
 * )
 */
class ShowRegion extends Controller
{
    public function __invoke($id)
    {
        return new RegionResource(Region::findOrFail($id));
    }
}
