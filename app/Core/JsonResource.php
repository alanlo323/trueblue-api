<?php

namespace App\Core;

use Illuminate\Http\Resources\Json\JsonResource as BaseResource;
use Illuminate\Support\Arr;

class JsonResource extends BaseResource
{
    public $expect = [];

    public $only = [];

    public static function collection($resource)
    {
        return new AnonymousResourceCollection($resource, get_called_class());
    }

    public function resolve($request = null)
    {
        $resolved = parent::resolve($request);

        return ! empty($this->only)
            ? Arr::only($resolved, $this->only)
            : Arr::except($resolved, $this->expect);
    }

    public function only($attributes = [])
    {
        $this->only = Arr::wrap($attributes);

        return $this;
    }

    public function except($attributes = [])
    {
        $this->except = Arr::wrap($attributes);

        return $this;
    }
}
