<?php

namespace App\Admin\Controllers;

use App\Models\Page;

class PageController extends PostController
{

    public $category = false;
    public $title    = 'Страницы';
    public $model    = Page::class;

    public $mainPage = true;

}
