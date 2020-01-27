<?php

namespace App\Http\Transformers;

use App\Models\Post;
use App\Services\RouteService;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = [
        'image',
        'category',
    ];

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post): array
    {
        return array_merge($post->attributesToArray(), [
            'type' => $post->getTable(),
            'links' => [
                'self' => route('posts.show', $post->id),
            ],
        ]);
    }

    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeImage(Post $post): Item
    {
        return $this->item($post->image, new ImageTransformer());
    }

    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeCategory(Post $post): Item
    {
        return $this->item($post->category, new CategoryTransformer());
    }

}
