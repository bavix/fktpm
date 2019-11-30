<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    /**
     * @var FilesystemAdapter
     */
    protected $storage;

    /**
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    /**
     * @fixme Добавить кропинг изображений
     * @param Image $image
     * @return string
     */
    public function xs(Image $image): string
    {
        return $this->xl($image);
    }

    /**
     * @param Image $image
     * @return string
     */
    public function xl(Image $image): string
    {
        return $this->storage->url($image->path);
    }

}
