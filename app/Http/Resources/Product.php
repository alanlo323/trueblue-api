<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\ProductAttribute as ProductAttributeResource;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="iPad Mini 4",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="description",
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         example="100",
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="number",
 *         example="4",
 *     ),
 *     @OA\Property(
 *         property="stock",
 *         type="number",
 *         example="0",
 *     ),
 *     @OA\Property(
 *         property="hasStock",
 *         type="boolean",
 *         example=false,
 *     ),
 *     @OA\Property(
 *         property="isVip",
 *         type="boolean",
 *         example=false,
 *     ),
 *     @OA\Property(
 *         property="isVariant",
 *         type="boolean",
 *         example=false,
 *     ),
 * )
 */
class Product extends JsonResource
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
            'title' => $this->name,
            'description' => $this->description,
            'price' => (double) $this->price,
            'rating' => (double) $this->rating,
            'stock' => (int) $this->stock,
            'hasStock' => (bool) $this->has_stock,
            'isVip' => (bool) $this->is_vip,
            'isVariant' => (bool) $this->is_variant,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'attributes' => ProductAttributeResource::collection($this->whenLoaded('attributes')),
            'variants' => static::collection($this->whenLoaded('variants')),
        ];
    }
}
