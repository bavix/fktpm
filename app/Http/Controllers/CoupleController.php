<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoupleController extends Controller
{

    protected $description = 'descriptions.couples';

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('couple.view', [
            'items' => Couple::query()
                ->where('active', 1)
                ->get(),

            'title'       => 'Предметы',
            'description' => __($this->description)
        ]);
    }

}
