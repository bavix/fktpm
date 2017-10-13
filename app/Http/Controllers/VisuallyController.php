<?php

namespace App\Http\Controllers;

use Bavix\Helpers\JSON;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;

class VisuallyController extends Controller
{

    protected $mixed;

    /**
     * @param Request $request
     * @param array   $cookie
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function data(Request $request, array $cookie = [])
    {
        if (!$this->mixed)
        {
            if ($request->ajax())
            {
                $this->mixed = response(JSON::encode(['ok']));
            }
            else
            {
                $this->mixed = redirect($this->refer($request));
            }
        }

        foreach ($cookie as $key => $value)
        {
            $this->mixed->withCookie(
                $this->cookie($key, $value)
            );
        }

        return $this->mixed;
    }

    protected function cookie($key, $value)
    {
        // 30 days
        return cookie($key, $value, 43200);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function refer(Request $request)
    {
        $refer = $request->server('HTTP_REFERER');
        $data  = \parse_url($refer);

        return $data['path'] ?? '/';
    }

    /**
     * @param Request $request
     *
     * @return ResponseTrait
     */
    public function index(Request $request)
    {
        // reset font & color
        $this->font($request, null);
        $this->color($request, null);

        return $this->data($request, [
            'visually'      => !\visually(),
            'visuallyImage' => \visually() ? false : \visuallyImage(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return ResponseTrait
     */
    public function image(Request $request)
    {
        return $this->data($request, [
            'visuallyImage' => !\visuallyImage()
        ]);
    }

    public function font(Request $request, $size)
    {
        if ($size <= 14 || $size >= 29)
        {
            $size = 20;
        }

        return $this->data($request)
            ->withCookie($this->cookie('visuallyFont', $size));
    }

    public function color(Request $request, $color)
    {
        switch ($color)
        {
            case 'white-black':
            case 'dark-blue-blue':
            case 'brown-beige':
            case 'green-dark-brown':
                break;
            default:
                $color = 'black-white';
        }

        return $this->data($request, [
            'visuallyColor' => $color
        ]);
    }

    public function notify(Request $request, $id)
    {
        return $this->data($request, [
            __FUNCTION__ . '[' . $id . ']' => $id,
        ]);
    }

}
