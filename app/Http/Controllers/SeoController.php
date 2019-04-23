<?php

namespace App\Http\Controllers;

use Bavix\App\Http\Controllers\Controller;

class SeoController extends Controller
{

    /**
     * @param string $url
     * @return void
     */
    public function redirect($url): void
    {
        header('location: ' . $url, true, 301);
        die;
    }

    /**
     * @return void
     */
    public function search(): void
    {
        $this->redirect(\route('search', ['posts']));
    }

    /**
     * @return void
     */
    public function helper(): void
    {
        $this->redirect(\route('helper'));
    }

    /**
     * @return void
     */
    public function teacher(): void
    {
        $this->redirect(\route('professor'));
    }

}
