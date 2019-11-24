<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class SeoController extends BaseController
{

    /**
     * @return RedirectResponse
     */
    public function helper(): RedirectResponse
    {
        return redirect(route('helper'), 301);
    }

    /**
     * @return RedirectResponse
     */
    public function teacher(): RedirectResponse
    {
        return redirect(route('professor'), 301);
    }

}
