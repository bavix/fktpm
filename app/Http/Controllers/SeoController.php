<?php

namespace App\Http\Controllers;

use Bavix\App\Http\Controllers\Controller;

class SeoController extends Controller
{

    /**
     * @param string $url
     */
    public function redirect($url)
    {
        header('location: ' . $url, true, 301);
        die;
    }

    public function search()
    {
        $this->redirect(\route('search', ['posts']));
    }

    public function helper()
    {
        $this->redirect(\route('helper'));
    }

    public function teacher()
    {
        $this->redirect(\route('professor'));
    }

}
