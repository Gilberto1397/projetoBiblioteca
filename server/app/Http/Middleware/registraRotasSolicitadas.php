<?php

namespace App\Http\Middleware;

use App\Repositories\RegistroRotaSolicitada\RegistroRotaSolicitadaRepositoryEloquent;
use App\Services\RegistroRotaSolicitada\CreateRegistroRotaSolicitadaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class registraRotasSolicitadas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $user = auth()->user();

        $registro = (new CreateRegistroRotaSolicitadaService(
            new RegistroRotaSolicitadaRepositoryEloquent()
        ))->create(
            $request->getRequestUri(),
            $request->method(),
            $request->getHost(),
            $request->userAgent(),
            now()->toDateTimeString(),
            (!empty($user) ? auth()->user()->getAuthIdentifier() : null)
        );

        if (!$registro) {
            throw new \Exception($registro->message);
        }
        return $response;
    }
}
