<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{

    public function index(Request $request)
    {
        return $this->render('helper.view');
    }

}
