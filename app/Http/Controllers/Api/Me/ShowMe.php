<?php

namespace App\Http\Controllers\Api\Me;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/v1/me",
 *     operationId="me.showMe",
 *     tags={"Me"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 * )
 */
class ShowMe extends Controller
{
    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }
}
