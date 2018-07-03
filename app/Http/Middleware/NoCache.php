<?php

namespace App\Http\Middleware;

use Closure;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        //$response->header('Cache-Control', 'no-cache, must-revalidate');
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('x-xsrf-token', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
        //$response->header('Content-Type', 'application/json; charset=utf-8');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, X-XSRF-TOKEN');
        return $response;
    }
}