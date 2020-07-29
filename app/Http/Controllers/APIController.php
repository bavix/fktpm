<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlockResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class APIController extends BaseController
{

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     * @deprecated
     */
    public function blocks(Request $request): AnonymousResourceCollection
    {
        $tags = \Cache::remember(__METHOD__, now()->addHour(), function () {
            return Tag::with('files.tags')
                ->orderBy('order_column', 'desc')
                ->where('is_block', 1)
                ->get();
        });

        return BlockResource::collection($tags);
    }

}
