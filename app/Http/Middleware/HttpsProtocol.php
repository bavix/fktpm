<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{

    public function handle(Request $request, Closure $next)
    {
        $request::setTrustedProxies([$request->getClientIp()]);

        $port = $request->secure() ? 443 : 80;

        $request->server->set('HTTP_PORT', $port);
        $request->server->set('SERVER_PORT', $port);
        $request->server->set('HTTP_X_FORWARDED_PORT', $port);

        $request->headers->set('port', [$port]);
        $request->headers->set('x-forwarded-port', [$port]);

//        if (!$request->secure())
//        {
//            return redirect()->secure($request->getRequestUri());
//        }

        return $next($request);
    }

}
