<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // RULE Headers yang harus di set seacara spesifik
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With', 'ACCEPT', 'CONTENT-TYPE', 'X-CSRF-TOKEN'
        ];

        if($request->isMethod('OPTIONS')) {
                return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }


        $response = $next($request);

        foreach($headers as $key => $row) {
            $response->header($key, $row);
        }

        return $response;

        // $allowedOrigins = [env('FRONTEND_ENDPOINT', 'http://192.168.0.94:9000'), env('WORDPRESS_ENDPOINT', 'http://localhost'), env('EXTRA_ENDPOINT', 'http://127.0.0.1')];

        // if($request->server('HTTP_ORIGIN')){
        //   if (in_array($request->server('HTTP_ORIGIN'), $allowedOrigins)) {
        //       return $next($request)
        //           ->header('Access-Control-Allow-Origin', $request->server('HTTP_ORIGIN'))
        //           ->header('Access-Control-Allow-Origin', '*')
        //           ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        //           ->header('Access-Control-Allow-Headers', '*');
        //   }
        // }


        // return $next($request);
    }
}
