<?php

namespace App\Http\Controllers;

use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{

    protected $description = 'descriptions.helper';

    public function index(Request $request)
    {
        return $this->render('helper.view', [
            'title'       => 'Помощь проекту',
            'description' => __($this->description)
        ]);
    }

}
