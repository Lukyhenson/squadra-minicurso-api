<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Implementação para solucionar problema de 'Cross-Origin Resource Sharing'.
 *
 * @author Squadra Tecnologia S/A.
 * @author Squadra Tecnologia S/A.
 */
class Cors
{

    /**
     * Intercepta a 'Request' e aplica a solução 'Cors'.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $allowHeader = 'Accept, Content-Type, Access-Control-Allow-Headers, Access-Control-Request-Method, ';
        $allowHeader .= 'Authorization, X-Token, X-Requested-With';
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', $allowHeader);
        $response->header('Access-Control-Max-Age', '3600');

        if ($request->isMethod('OPTIONS')) {
            $response->setStatusCode(200);
            $response->setContent('OK');
        }

        return $response;
    }
}
