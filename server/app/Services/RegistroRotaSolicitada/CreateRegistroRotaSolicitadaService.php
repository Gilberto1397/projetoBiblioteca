<?php

namespace App\Services\RegistroRotaSolicitada;

use App\Repositories\RegistroRotaSolicitada\RegistroRotaSolicitadaRepository;

class CreateRegistroRotaSolicitadaService
{
    private RegistroRotaSolicitadaRepository $registroRotaSolicitadaRepository;

    public function __construct(RegistroRotaSolicitadaRepository $registroRotaSolicitadaRepository)
    {
        $this->registroRotaSolicitadaRepository = $registroRotaSolicitadaRepository;
    }

    /**
     * Create a new record in the database of the requested route.
     * @param  string  $route
     * @param  string  $method
     * @param  string  $host_request
     * @param  string  $user_agent
     * @param  string  $dateRequest
     * @param  int|null  $userRequest
     * @return object
     */
    public function create(
        string $route,
        string $method,
        string $host_request,
        string $user_agent,
        string $dateRequest,
        int $userRequest = null
    ): object {
        $response = (object)[
            'message' => 'Registro de rota solicitada criado com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];

        $registro = $this->registroRotaSolicitadaRepository->create(
            $route,
            $method,
            $host_request,
            $user_agent,
            $dateRequest,
            $userRequest
        );

        if (!$registro) {
            $response = (object)[
                'message' => 'Falha ao criar registro de rota solicitada!',
                'statusCode' => 500,
                'error' => true
            ];
        }
        return $response;
    }
}
