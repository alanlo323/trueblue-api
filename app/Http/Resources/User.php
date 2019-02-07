<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @OA\Schema(
 *     description="User",
 *     type="object",
 *     title="User",
 * )
 * @OA\Property(
 *     property="id",
 *     type="string",
 *     example="erBEOm6vAy",
 * )
 * @OA\Property(
 *     property="name",
 *     type="string",
 *     example="Peter Pan",
 * )
 * @OA\Property(
 *     property="email",
 *     type="string",
 *     nullable=true,
 *     example="me@example.com",
 * )
 * @OA\Property(
 *     property="isVip",
 *     type="boolean",
 * )
 */
class User extends \App\Core\JsonResource
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
            'id' => $id = Hashids::encode($this->id),
            'name' => $this->name,
            'email' => $this->email,
            'qrcode' => route('qrcode', ['content' => $id]),
            'isVip' => (bool) $this->is_vip,
        ];
    }
}
