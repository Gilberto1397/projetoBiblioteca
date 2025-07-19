<?php

namespace App\Services\Publisher;

use App\Http\Requests\Publisher\PublisherRequest;
use App\Repositories\Publisher\PublisherRepository;

class CreatePublisherService
{
    private PublisherRepository $publisherRepository;

    public function __construct(PublisherRepository $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    /**
     * @param  PublisherRequest  $publisherRequest
     * @return object
     */
    public function createPublisher(PublisherRequest $publisherRequest):object
    {
        $response = (object)[
            'message' => 'Editora criada com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];

        $saved = $this->publisherRepository->createPublisher($publisherRequest);

        if (!$saved) {
            $response = (object)[
                'message' => 'Falha ao criar Editora!',
                'statusCode' => 500,
                'error' => true
            ];
        }

        return $response;
    }
}
