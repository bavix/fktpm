<?php

namespace App\Observers;

use App\Console\Commands\ImageOptimizeCommand;
use App\Models\Image;
use Bavix\Extra\Gearman;

class ImageObserver
{

    /**
     * @param Image $image
     *
     * @return void
     */
    public function created(Image $image)
    {
        Gearman::client()->doLowBackground(
            ImageOptimizeCommand::PROP_OPTIMIZE_IMAGE,
            \serialize($image)
        );
    }

}
