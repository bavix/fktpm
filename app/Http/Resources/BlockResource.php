<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BlockResource extends Resource
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
            'title' => $this->name,
            'count' => $this->files->count(),
            'files' => FileResource::collection($this->files)
        ];
    }

}
