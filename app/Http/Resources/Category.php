<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="手機及平板電腦",
 *     ),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                 property="id",
 *                 type="string",
 *                 example="9ymo1knaAZ",
 *             ),
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 example="手提電話",
 *             ),
 *         ),
 *     ),
 * )
 */
class Category extends JsonResource
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
            'id' => Hashids::encode($this->id),
            'name' => $this->name,
            'children' => static::collection($this->whenLoaded('children')),
        ];
    }
}
