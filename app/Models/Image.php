<?php

namespace App\Models;

use Bavix\Gearman\Client;
use Bavix\Helpers\Dir;
use Illuminate\Database\Eloquent\Model;
use ImageOptimizer\OptimizerFactory;

class Image extends Model
{

    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * @var array
     */
    public $resizeList = [
        'thumbs',
        'preview',
        'fullHD'
    ];

    protected function gearman($name, $data)
    {
        if (class_exists(\GearmanClient::class))
        {
            try
            {
                $client = new Client();
                $client->addServer(
                    config('gearman.host'),
                    config('gearman.port')
                );

                $client->doBackground($name, $data);
            }
            catch (\Throwable $throwable)
            {
            }
        }
    }

    public function doBackground()
    {
        $this->gearman('resize', serialize($this));
    }

    /**
     * @param $path
     */
    protected function optimize($path)
    {
        $this->gearman('optimize', $path);
    }

    /**
     * @param int $width
     *
     * @return string
     */
    protected function resize($width, $height = null)
    {
        $path = 'thumbs/' . ($width ?: 'h' . $height) . '/' . $this->src;
        $real = public_path('upload/' . $path);
        $org  = public_path('upload/' . $this->src);

        // placeHoldIt
        if (!realpath($real) && !realpath($org))
        {
            $path = 'default/' . ($width ?: 'h' . $height) . '/placeholdit.png';
            $real = public_path('upload/' . $path);
            $org  = public_path('default/placeholdit.png');
        }

        try
        {

            if (!realpath($real))
            {
                $dir = dirname($real);

                Dir::make($dir);

                $image = \Intervention\Image\Facades\Image::make($org);

                $_width  = null;
                $_height = null;

                if (!$height)
                {
                    $_width = $image->width() <= $width ? $image->width() : $width;
                }
                else
                {
                    $_height = $image->height() <= $height ? $image->height() : $height;
                }

                $image->resize($_width, $_height, function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $image->save($real);
                $this->optimize($real);

            }

            return $path;

        }
        catch (\Throwable $throwable)
        {
            return $this->src;
        }

    }

    public function thumbs()
    {
        return $this->resize(null, 130);
    }

    public function preview()
    {
        return $this->resize(730);
    }

    public function fullHD()
    {
        return $this->resize(1920);
    }

}
