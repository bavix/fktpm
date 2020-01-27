<?php

namespace App\Http\Transformers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{

    /**
     * @param Image $image
     * @return array
     */
    public function transform(Image $image): array
    {
        return array_merge($image->attributesToArray(), [
            'type' => $image->getTable(),
            'links' => [
                'self' => route('images.show', $image->id),
            ],
        ]);
    }

}
