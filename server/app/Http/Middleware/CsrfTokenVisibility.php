<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Devolve o CSRF-TOKEN na rota espcífica /obiscoitincsrf
 * e apaga o cookie no cliente após uma requisição que necessita do mesmo.
 */
class CsrfTokenVisibility
{
    const ROTA_SANCTUM = '/obiscoitincsrf';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $solicitation = $next($request);

        if ($request->getPathInfo() !== self::ROTA_SANCTUM) {
            $solicitation->headers->removeCookie('XSRF-TOKEN');
            setcookie('XSRF-TOKEN', '', time()-3600);
        }
        return $solicitation;
    }
}
