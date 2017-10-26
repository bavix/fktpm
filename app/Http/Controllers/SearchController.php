<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function files(Request $request)
    {

    }

    public function posts(Request $request)
    {

    }

    public function couples(Request $request)
    {

    }

    public function professors(Request $request)
    {

    }

    public function index(Request $request, $action)
    {
        abort_if(!method_exists($this, $action), 404);

        $this->{$action}($request);

        return $this->render('search.view', [
            'action' => $action
        ]);
    }

}
