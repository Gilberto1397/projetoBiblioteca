<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Services\User\CreateUserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param  UserRequest  $userRequest
     * @param  CreateUserService  $createUserService
     * @return JsonResponse
     */
    public function createUser(UserRequest $userRequest, CreateUserService $createUserService):JsonResponse
    {
        $response = $createUserService->createUser($userRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }
}
