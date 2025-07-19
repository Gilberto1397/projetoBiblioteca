<?php

namespace App\Services\Publisher;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Resources\Publisher\PublisherCollectionResource;
use App\Repositories\Publisher\PublisherRepository;

class GetPublisherService
{
    private PublisherRepository $publisherRepository;

    public function __construct(PublisherRepository $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    /**
     * Return all editors filtered according to the parameters entered, or all editors.
     * @param  PublisherFiltersRequest  $publisherFiltersRequest
     * @return object
     */
    public function getPublisher(PublisherFiltersRequest $publisherFiltersRequest): object
    {
        $publishers = [];

        if (!empty($publisherFiltersRequest->all())) {
            $publishers = $this->publisherRepository->filteredPublishers($publisherFiltersRequest);
        }

        if ($publisherFiltersRequest->allPublishers) {
            $publishers = $this->publisherRepository->getAllPublishers();
        }

        return (object)[
            'message' => '',
            'statusCode' => 200,
            'error' => false,
            'data' => new PublisherCollectionResource($publishers)
        ];
    }
}
