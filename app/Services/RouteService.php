<?php

namespace App\Services;

use App\Models\Category;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class RouteService
{

    /**
     * @param File $file
     * @return string
     */
    public function file(File $file): string
    {
        return route('file', [$file->getKey(), Str::slug($file->title), $file->type]);
    }

    /**
     * @param Tag $tag
     * @return string
     */
    public function fileTag(Tag $tag): string
    {
        return route('file.tag', [$tag->slug]);
    }

    /**
     * @param Post $post
     * @return string
     */
    public function post(Post $post): string
    {
        return route('post.view', [$post->getKey(), Str::slug($post->title)]);
    }

    /**
     * @param Category $category
     * @return string
     */
    public function postCategory(Category $category): string
    {
        return route('post.category', [$category->getKey(), Str::slug($category->title)]);
    }

    /**
     * @param Tag $tag
     * @return string
     */
    public function postTag(Tag $tag): string
    {
        return route('post.tag', [$tag->slug]);
    }

}
