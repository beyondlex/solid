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
        header('Access-Control-Allow-Origin: '. $this->getAllowOrigin());
        //响应web端预检请求：
        if (request()->isMethod('options')) {
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
            header('Access-Control-Allow-Headers: Content-Type');
            header('Access-Control-Max-Age: ' . 60 * 60 * 24);
            exit;
        }
        return $next($request);
    }

    protected function getAllowOrigin()
    {
        $app = app();
        if ($app->environment('production', 'staging')) {
            return env('ALLOW_ORIGIN');
        } else {
            return '*';
        }

    }
}

