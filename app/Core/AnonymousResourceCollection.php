<?php

namespace App\Core;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection as BaseCollection;
use Illuminate\Support\Arr;

class AnonymousResourceCollection extends BaseCollection
{
    public $expect = [];

    public $only = [];

    public function resolve($request = null)
    {
        $resolved = parent::resolve($request);

        return array_map(function ($resolved) {
            return ! empty($this->only)
                ? Arr::only($resolved, $this->only)
                : Arr::except($resolved, $this->expect);
        }, $resolved);
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
