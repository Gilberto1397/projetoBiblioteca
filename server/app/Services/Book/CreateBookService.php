<?php

namespace App\Services\Book;

use App\Http\Requests\Book\BookRequest;
use App\Repositories\Book\BookRepository;

class CreateBookService
{
    protected BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param  BookRequest  $bookRequest
     * @return object
     */
    public function createBook(BookRequest $bookRequest):object
    {
        $response = (object)[
            'message' => 'Livro criado com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];
        $saved = $this->bookRepository->createBook($bookRequest);

        if (!$saved) {
            $response = (object)[
                'message' => 'Falha ao criar livro!',
                'statusCode' => 500,
                'error' => true
            ];
        }
        return $response;
    }
}
