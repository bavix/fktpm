<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class CoupleController extends BaseController
{

    /**
     * @var string
     */
    protected $description = 'descriptions.couples';

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('couple.view', [
            'items' => Couple::query()
                ->where('active', 1)
                ->get(),

            'title' => trans('Предметы'),
            'description' => trans($this->description)
        ]);
    }

}
