<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends AlbumController
{

    protected $model       = Page::class;
    protected $route       = 'page';
    protected $title       = 'blocks.pages';
    protected $description = 'blocks.listPages';

    protected $mainPage = true;

    public function main(Request $request)
    {
        $model = Page::query()
            ->where('main_page', 1)
            ->where('active', 1)
            ->first();

        abort_if(!$model, 404);

        return $this->view($request, $model);
    }

}
