<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @OA\Schema(
 *     schema="ProductAttribute",
 *     type="object",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="color",
 *     ),
 *     @OA\Property(
 *         property="options",
 *         type="array",
 *         example={"灰色", "銀色", "金色"},
 *         @OA\Items(type="string"),
 *     ),
 *     @OA\Property(
 *         property="value",
 *         type="string",
 *         example="",
 *     ),
 * )
 */
class ProductAttribute extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
//            'id' => Hashids::encode($this->id),
            'name' => $this->name,
            $this->mergeWhen(empty($this->pivot->value), [
                'options' => $this->options,
            ]),
            'value' => $this->pivot->value,
        ];
    }
}
