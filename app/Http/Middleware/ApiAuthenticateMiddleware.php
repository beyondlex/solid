<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;

class ApiAuthenticateMiddleware
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
		//client_id, params, sign
        $post = $request->post();
        $clientId = $request->header('client-id');
        $sign = $request->header('sign');
        if (!$sign) {
        	throw new UnauthorizedException('The sign should be provided.');
		}
        if (!isset($clientId)) {
            throw new UnauthorizedException('Client_id can not be empty.');
        }
        $client = Client::find($clientId);
        if (!$client) {
            throw new UnauthorizedException('Invalid client.');
        }
        if ($client->revoked) {
            throw new UnauthorizedException('The client has been revoked.');
        }
        $secret = $client->secret;

        $params = $post;
        ksort($params);
        $str = '';
        foreach ($params as $k=>$v) {
            if (!$v) continue;
            if (!is_string($v)) continue;
            $str .= $k.'='.$v.';';
        }
        $str = $secret. $str .$request->getPathInfo();
        $signExpect = sha1($str);

        if ($signExpect != $sign) {
            throw new UnauthorizedException('Invalid sign');
        }

        \App::singleton('curato', function() use ($client) {
			$curato = new \stdClass();
			$curato->client = $client;
			return $curato;
		});

        return $next($request);
    }
}
