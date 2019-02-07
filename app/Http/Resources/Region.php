<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Resources\Location as LocationResource;

/**
 * @OA\Schema(
 *     schema="Region",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="香港",
 *     ),
 *     @OA\Property(
 *         property="isDefault",
 *         type="boolean",
 *         example=false,
 *     ),
 * )
 */
class Region extends JsonResource
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
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'isDefault' => (bool) $this->is_default,
        ];
    }
}
