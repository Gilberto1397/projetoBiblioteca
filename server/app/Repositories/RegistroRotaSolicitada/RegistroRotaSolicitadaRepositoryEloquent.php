<?php

namespace App\Repositories\RegistroRotaSolicitada;

use App\Models\RegistroRotaSolicitada;

class RegistroRotaSolicitadaRepositoryEloquent implements RegistroRotaSolicitadaRepository
{
    /**
     * Create a new record in the database with the route requested.
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
    ): bool {
        try {
            $registroRota = new RegistroRotaSolicitada();
            $registroRota->route = $route;
            $registroRota->method = $method;
            $registroRota->host_request = $host_request;
            $registroRota->user_agent = $user_agent;
            $registroRota->date_request = $dateRequest;
            $registroRota->user_requesting = $userRequest;

            return $registroRota->save();
        } catch (\PDOException $exception) {
            return false;
        }
    }
}
