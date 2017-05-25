<?php

namespace App\Models;

use Bavix\Helpers\Dir;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class ImageModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * @param int $width
     *
     * @return string
     */
    protected function resize($width)
    {
        $path = 'thumbs/' . $width . '/' . $this->src;
        $real = public_path('upload/' . $path);

        if (!realpath($real))
        {
            $org = public_path('upload/' . $this->src);
            $dir = dirname($real);

            Dir::make($dir);

            $image = Image::make($org);

            $image->fit($image->width() < $width ? $image->width() : $width)->save($real);
        }

        return $path;
    }

    public function thumbs()
    {
        return $this->resize(200);
    }

    public function preview()
    {
        return $this->resize(730);
    }

}
