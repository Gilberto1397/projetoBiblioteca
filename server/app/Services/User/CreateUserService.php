<?php

namespace App\Services\User;

use App\Http\Requests\User\UserRequest;
use App\Repositories\User\UserRepository;

class CreateUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param  UserRequest  $userRequest
     * @return object
     */
    public function createUser(UserRequest $userRequest):object
    {
        $response = (object)[
            'message' => 'Usuário criado com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];
        $saved = $this->userRepository->createUser($userRequest);

        if (!$saved) {
            $response = (object)[
                'message' => 'Falha ao criar usuário',
                'statusCode' => 500,
                'error' => true
            ];
        }

        return $response;
    }
}
