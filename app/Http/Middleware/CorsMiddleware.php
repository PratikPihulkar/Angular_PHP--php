<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (is_null($response)) {
            $response = response('');
        }    

        // Set headers to allow CORS
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:4200'); // your Angular app's URL
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        
        return $response;
    }
}