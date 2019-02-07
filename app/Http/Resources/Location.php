<?php

namespace App\Http\Resources;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Resources\Link as LinkResource;

/**
 * @OA\Schema(
 *     schema="Location",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="erBEOm6vAy",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="銅鑼灣廣場一期",
 *     ),
 *     @OA\Property(
 *         property="lat",
 *         type="number",
 *         format="double",
 *         example=22.280212,
 *     ),
 *     @OA\Property(
 *         property="lng",
 *         type="number",
 *         format="double",
 *         example=114.180363,
 *     ),
 *     @OA\Property(
 *         property="isOpening",
 *         type="boolean",
 *         example=false,
 *     ),
 *     @OA\Property(
 *         property="openingHours",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                 property="weekday",
 *                 type="integer",
 *                 example=0,
 *             ),
 *             @OA\Property(
 *                 property="openAt",
 *                 type="string",
 *                 example="08:00",
 *             ),
 *             @OA\Property(
 *                 property="closeAt",
 *                 type="string",
 *                 example="17:00",
 *             ),
 *         ),
 *     ),
 * )
 */
class Location extends JsonResource
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
            'lat' => $this->coord->getLat(),
            'lng' => $this->coord->getLng(),
            'isOpening' => $this->is_opening,
            'openingHours' => $this->transform(
                $this->opening_hours,
                Closure::fromCallable([$this, 'transformOpeningHours']),
                []
            ),
            'links' => LinkResource::collection($this->whenLoaded('links')),
        ];
    }

    protected function transformOpeningHours($openingHours) {
        return collect()
            ->times(7, function ($number) {
                return [
                    'weekday' => $number - 1,
                    'openAt' => null,
                    'closeAt' => null,
                ];
            })
            ->map(function ($day) use ($openingHours) {
                if (empty($openingHours[$day['weekday']])) {
                    return $day;
                }

                [$openAt, $closeAt] = $openingHours[$day['weekday']] ?? [];

                return array_merge($day, compact('openAt', 'closeAt'));
            });
    }
}
