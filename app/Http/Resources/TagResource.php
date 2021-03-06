<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'url' => \route('file.tag', [$this->slug]),
            'exists' => $this->is_block,
        ];
    }

}
