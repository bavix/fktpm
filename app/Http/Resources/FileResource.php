<?php

namespace App\Http\Resources;

use App\Services\FileService;
use App\Services\HumanService;
use App\Services\RouteService;
use Illuminate\Http\Resources\Json\Resource;

class FileResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'url' => app(RouteService::class)->file($this->resource),
            'size' => app(HumanService::class)->fileSize($this->size),
            'class' => app(FileService::class)->icon($this->resource),
            'tags' => TagResource::collection($this->tags),
        ];
    }

}
