<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class HelperController extends BaseController
{

    /**
     * @var string
     */
    protected $description = 'descriptions.helper';

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('helper.view', [
            'title' => trans('Помощь проекту'),
            'description' => trans($this->description)
        ]);
    }

}
