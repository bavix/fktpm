<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlockResource;
use App\Http\Transformers\PostTransformer;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class APIController extends BaseController
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     * @deprecated
     */
    public function blocks(Request $request): AnonymousResourceCollection
    {
        $tags = Tag::with('files.tags')
            ->orderBy('order_column', 'desc')
            ->where('is_block', 1)
            ->get();

        return BlockResource::collection($tags);
    }

    public function hello(Request $request)
    {
        $queryBuilder = QueryBuilder::for(Post::latest());
        $queryBuilder->allowedIncludes(['image', 'category']);
        $paginate = $queryBuilder->paginate();

        return fractal()
            ->collection($paginate)
            ->transformWith(new PostTransformer())
            ->toArray();
    }

}
