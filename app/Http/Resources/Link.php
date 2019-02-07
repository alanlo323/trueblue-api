<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Link",
 *     type="object",
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         example="instagram",
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="title",
 *     ),
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         example="https://www.instagram.com/nike/",
 *     ),
 * )
 */
class Link extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'link' => $this->link,
        ];
    }
}
