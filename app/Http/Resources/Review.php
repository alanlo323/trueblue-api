<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Resources\User as UserResource;

/**
 * @OA\Schema(
 *     schema="Review",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         ref="#/components/schemas/User",
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="title",
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         example="good product",
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="number",
 *         example="4",
 *     ),
 * )
 */
class Review extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user'))->only(['id', 'name']),
            'title' => $this->title,
            'content' => $this->content,
            'rating' => (double) $this->rating,
        ];
    }
}
