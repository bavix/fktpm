<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;

class PostService
{

    /**
     * @param string $title
     * @return Category
     */
    public function getCategory(string $title): Category
    {
        return Category::firstOrCreate(compact('title'));
    }

    /**
     * @param string $code
     * @return Post|null
     */
    public function byInstagramCode(string $code): ?Post
    {
        return Post::whereInstagramCode($code)->first();
    }

    /**
     * @param Post $post
     * @param Image $image
     * @return bool
     */
    public function setImage(Post $post, Image $image): bool
    {
        return $post->update(['image_id' => $image->id]);
    }

    /**
     * @param Post $post
     * @param array $images
     * @return bool
     */
    public function addImages(Post $post, array $images): bool
    {
        return !empty($post->images()->saveMany($images));
    }

    /**
     * @param array $urls
     * @return Image[]
     */
    public function upload(array $urls): array
    {
        $models = [];
        foreach ($urls as $url) {
            $path = app(ImageService::class)->putImage($url);
            if ($path) {
                $models[] = Image::create(['path' => $path]);
            }
        }

        return $models;
    }

}
