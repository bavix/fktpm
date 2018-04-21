<?php

namespace App\Http\Resources;

use Bavix\Helpers\Str;
use Illuminate\Http\Resources\Json\Resource;

class FileResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url(),
            'size' => Str::fileSize($this->size),
            'class' => $this->faType(),
            'tags' => TagResource::collection($this->tags)
        ];
    }

}
