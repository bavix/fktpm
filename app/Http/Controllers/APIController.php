<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlockResource;
use App\Models\Tag;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{

    public function blocks(Request $request)
    {
        $currentPage = $request->input('page', 1);
        
        return BlockResource::collection(Cache::remember('tags_block_' . $currentPage, 60, function() { 
            return Tag::blocks()->paginate(100); 
        }));
    }

}
