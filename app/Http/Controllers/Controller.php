<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Trueblue",
 *     description="Trueblue OpenApi description",
 * )
 * @OA\Server(url="/api")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 * @OA\Tag(
 *     name="Auth",
 * )
 * @OA\Tag(
 *     name="Me",
 * )
 * @OA\Tag(
 *     name="Region",
 * )
 * @OA\Tag(
 *     name="Misc",
 * )
 */
/**
 * @OA\Get(
 *     path="/qrcode/text/{content}",
 *     operationId="me.showMe",
 *     tags={"Misc"},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
