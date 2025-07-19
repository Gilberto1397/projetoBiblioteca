<?php

namespace App\Services\Login;

use App\Http\Requests\Login\loginRequest;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @param  loginRequest  $loginRequest
     * @return object
     */
    public function login(loginRequest $loginRequest)
    {
        $response = (object)[
            'message' => 'Logado com sucesso!',
            'statusCode' => 200,
            'error' => false
        ];

        if (Auth::attempt(['user_email' => $loginRequest->email, 'password' => $loginRequest->password])) {
            $loginRequest->session()->regenerate();
            return $response;
        }

        return (object)[
            'message' => 'Dados informados inválidos!',
            'statusCode' => 401,
            'error' => true
        ];
    }
}
