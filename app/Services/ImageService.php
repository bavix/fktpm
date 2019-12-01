<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    /**
     * @return string
     */
    public function placeholder(): string
    {
        return '/favicons/android-icon-192x192.png';
    }

    /**
     * @param string $url
     * @return null|string
     */
    public function putImage(string $url): ?string
    {
        try {
            $path = $this->getNewPath();
            $this->storage->makeDirectory(dirname($path));
            $handle = $this->handle($url);
            $success = $handle && $this->storage->put($path, $handle);
            fclose($handle);
            abort_if(!$success, 400);
            return $path;
        } catch (\Throwable $throwable) {
            return null;
        }
    }

    /**
     * @param string $url
     * @return resource
     */
    protected function handle(string $url)
    {
        return fopen($url, 'rb', false, stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", [
                    'Accept-language: en',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
                ]),
            ],
        ]));
    }

    /**
     * @return string
     */
    protected function getNewPath(): string
    {
        $filename = Str::random() . '.jpg';
        $folders = str_split(substr($filename, 0, 4), 2);
        return 'image/' . implode('/', array_merge($folders, [$filename]));
    }

}
