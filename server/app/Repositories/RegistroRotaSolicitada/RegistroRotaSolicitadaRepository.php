<?php

namespace App\Repositories\RegistroRotaSolicitada;

interface RegistroRotaSolicitadaRepository
{
    /**
     * Create a new record in the database of the requested route.
     * @param  string  $route
     * @param  string  $method
     * @param  string  $host_request
     * @param  string  $user_agent
     * @param  string  $dateRequest
     * @param  int|null  $userRequest
     * @return bool
     */
    public function create(
        string $route,
        string $method,
        string $host_request,
        string $user_agent,
        string $dateRequest,
        int $userRequest = null
    ): bool;
}
