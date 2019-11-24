<?php

namespace App\Services;

use App\Models\Image;

class ImageService
{

    /**
     * @param Image $image
     * @return string
     */
    public function xs(Image $image): string
    {
        return 'image-' . $image->getKey();
    }

}
