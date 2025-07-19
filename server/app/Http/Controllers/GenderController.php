<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gender\GenderRequest;
use App\Services\Gender\createGendersService;
use Illuminate\Http\JsonResponse;

class GenderController extends Controller
{
    /**
     * @param  GenderRequest  $genderRequest
     * @param  createGendersService  $service
     * @return JsonResponse
     */
    public function createGenders(GenderRequest $genderRequest, createGendersService $createGenderService): JsonResponse
    {
        $response = $createGenderService->createGenders($genderRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }
}
