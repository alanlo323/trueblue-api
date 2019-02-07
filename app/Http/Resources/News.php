<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @OA\Schema(
 *     schema="News",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="title",
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         example="content",
 *     ),
 * )
 */
class News extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
