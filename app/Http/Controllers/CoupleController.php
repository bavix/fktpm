<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use Illuminate\Http\Request;

class CoupleController extends Controller
{

    public function index(Request $request)
    {
        return $this->render(
            'couple.view',
            [
                'items' => Couple::query()
                    ->where('active', 1)
                    ->get()
            ]
        );
    }

}
