<?php

namespace App\Services\Author;

use App\Http\Requests\Author\AuthorRequest;
use App\Repositories\Author\AuthorRepository;

class CreateAuthorService
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * Create a new author in the database.
     * @param  AuthorRequest  $authorRequest
     * @return object
     */
    public function createAuthor(AuthorRequest $authorRequest): object
    {
        $response = (object)[
            'message' => 'Autor criado com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];

        $saved = $this->authorRepository->createAuthor($authorRequest);

        if (!$saved) {
            $response = (object)[
                'message' => 'Falha ao criar Autor!',
                'statusCode' => 500,
                'error' => true
            ];
        }

        return $response;
    }
}
