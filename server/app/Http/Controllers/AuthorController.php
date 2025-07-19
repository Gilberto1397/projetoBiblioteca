<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\AuthorRequest;
use App\Services\Author\CreateAuthorService;
use App\Services\Author\GetAuthorsService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * @param  AuthorRequest  $authorRequest
     * @param  CreateAuthorService  $createAuthorService
     * @return JsonResponse
     */
    public function createAuthor(AuthorRequest $authorRequest, CreateAuthorService $createAuthorService):JsonResponse
    {
        $response = $createAuthorService->createAuthor($authorRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }

    /**
     * @param  GetAuthorsService  $getAuthorsService
     * @return JsonResponse
     */
    public function getAuthors(GetAuthorsService $getAuthorsService):JsonResponse
    {
        $response = $getAuthorsService->getAuthors();

        return response()->json(
            ['message' => $response->message, 'error' => $response->error, 'authors' => $response->data],
            $response->statusCode
        );
    }
}
