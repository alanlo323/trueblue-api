<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Translation\Translator;
use Spatie\TranslationLoader\LanguageLine;

/**
 * @OA\Get(
 *     path="/v1/i18n/{locale}",
 *     operationId="getI18n",
 *     tags={"Misc"},
 *     @OA\Parameter(
 *         name="locale",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             example="zh-HK",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="{key}",
 *                 type="string",
 *                 example="{value}",
 *             ),
 *         )
 *     )
 * )
 */
class GetI18n extends Controller
{
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function __invoke($locale, $group = 'ui')
    {
        return response()->json(
            LanguageLine::getTranslationsForGroup($locale, $group)
        );
    }
}
