<?php

namespace App\Http\Controllers;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Requests\Publisher\PublisherRequest;
use App\Services\Publisher\CreatePublisherService;
use App\Services\Publisher\GetPublisherService;
use Illuminate\Http\JsonResponse;

class PublisherController extends Controller
{
    /**
     * @param  PublisherRequest  $publisherRequest
     * @param  CreatePublisherService  $createPublisherService
     * @return JsonResponse
     */
    public function createPublisher(PublisherRequest $publisherRequest, CreatePublisherService $createPublisherService): JsonResponse
    {
        $response = $createPublisherService->createPublisher($publisherRequest);
        return response()->json(['message' => $response->message, 'error' => $response->error], $response->statusCode);
    }

    /**
     * @param  PublisherFiltersRequest  $publisherFiltersRequest
     * @param  GetPublisherService  $filterPublisherService
     * @return JsonResponse
     */
    public function getPublishers(
        PublisherFiltersRequest $publisherFiltersRequest,
        GetPublisherService $filterPublisherService
    ):JsonResponse {
       $response = $filterPublisherService->getPublisher($publisherFiltersRequest);

        return response()->json(
            ['message' => $response->message, 'error' => $response->error, 'data' => ['publishers' => $response->data]],
            $response->statusCode
        );
    }
}
