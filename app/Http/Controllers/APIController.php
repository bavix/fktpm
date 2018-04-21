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
        return BlockResource::collection(Tag::blocks()->paginate());
    }

}
