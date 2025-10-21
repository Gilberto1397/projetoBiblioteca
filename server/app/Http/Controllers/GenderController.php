<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gender\GenderRequest;
use App\Services\Gender\CreateGendersService;
use Illuminate\Http\JsonResponse;

class GenderController extends Controller
{
    /**
     * @param  GenderRequest  $genderRequest
     * @param  CreateGendersService  $createGenderService
     * @return JsonResponse
     */
    public function createGenders(GenderRequest $genderRequest, CreateGendersService $createGenderService): JsonResponse
    {
        $response = $createGenderService->createGenders($genderRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }
}
