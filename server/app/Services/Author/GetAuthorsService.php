<?php

namespace App\Services\Author;

use App\Http\Resources\Author\AuthorCollectionResource;
use App\Repositories\Author\AuthorRepository;
use Illuminate\Database\Eloquent\Collection;

class GetAuthorsService
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }


    /**
     * Service responsible for returning all registered authors
     * @return object
     */
    public function getAuthors(): object
    {
        return (object)[
            'message' => '',
            'statusCode' => 200,
            'error' => false,
            'data' => (
            !empty($this->authorRepository->getAuthors()) ?
                new AuthorCollectionResource($this->authorRepository->getAuthors()) :
                []
            )
        ];
    }
}
