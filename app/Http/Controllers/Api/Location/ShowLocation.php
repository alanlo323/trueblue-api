<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location as LocationResource;
use App\Models\Location;

/**
 * @OA\Get(
 *     path="/v1/locations/{id}",
 *     operationId="location.showLocation",
 *     tags={"Location"},
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
 *                 @OA\Schema(ref="#/components/schemas/Location"),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(
 *                         property="links",
 *                         type="array",
 *                         @OA\Items(ref="#/components/schemas/Link"),
 *                     ),
 *                 ),
 *             }
 *         )
 *     ),
 * )
 */
class ShowLocation extends Controller
{
    public function __invoke($id)
    {
        return new LocationResource(
            Location::with('links')->findOrFail($id)
        );
    }
}
