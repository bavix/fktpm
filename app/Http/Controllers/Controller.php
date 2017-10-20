<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Counter;
use App\Models\Link;
use App\Models\Page;
use App\Models\Poll;
use App\Models\Tracker;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @param string $mixed
     * @param array  $data
     * @param array  $merge
     *
     * @return \Illuminate\Http\Response
     */
    public function render($mixed, $data = [], $merge = [])
    {
        $view = view($mixed, $data, $merge);

        $response = new \Illuminate\Http\Response($view);

        if (!empty($this->cookies))
        {
            foreach ($this->cookies as $cookie)
            {
                $response->withCookie($cookie);
            }
        }

        return $response;

    }

    /**
     * @param array ...$arguments
     */
    public function setCookie(...$arguments)
    {
        if (!isset($arguments[2]))
        {
            $arguments[2] = 365 * (24) * 60;
        }

        $this->cookies[] = \cookie(...$arguments);
    }

}
