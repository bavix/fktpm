<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class LanguageHandle
{

    protected $languages = [];

    public function __construct()
    {
        $this->languages = config('bx.languages', ['en', 'ru']);
    }

    public function handle(Request $request, \Closure $next)
    {
        $locale = bx_cookie('locale', $request->getPreferredLanguage($this->languages));

        app()->setLocale($locale);

        return $next($request);
    }

}