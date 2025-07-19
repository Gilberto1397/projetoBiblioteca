<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\loginRequest;
use App\Services\Login\LoginService;
use App\Services\Login\LogoutService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * @param  loginRequest  $loginRequest
     * @param  LoginService  $loginService
     * @return JsonResponse
     */
    public function login(loginRequest $loginRequest, LoginService $loginService):JsonResponse
    {
        $response = $loginService->login($loginRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }

    /**
     * @param  LogoutService  $logoutService
     * @return JsonResponse
     */
    public function logout(LogoutService $logoutService): JsonResponse
    {
        $response = $logoutService->logout();
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }
}
