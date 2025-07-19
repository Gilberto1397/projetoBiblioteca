<?php

namespace App\Services\Book;

use App\Http\Requests\Book\FilteredBooksRequest;
use App\Http\Resources\Book\BookCollectionResource;
use App\Repositories\Book\BookRepository;

class GetBooksService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param  FilteredBooksRequest  $filteredBooksRequest
     * @return object
     */
    public function getBooks(FilteredBooksRequest $filteredBooksRequest):object
    {
        $books = [];

        if (!empty($filteredBooksRequest->all()) && !$filteredBooksRequest->allBooks) {
            $books = $this->bookRepository->getFilteredBooks($filteredBooksRequest);
        }

        if ($filteredBooksRequest->allBooks) {
            $books = $this->bookRepository->getAllBooks();
        }

        return (object)[
            'message' => '',
            'statusCode' => 200,
            'error' => false,
            'data' => new BookCollectionResource($books)
        ];
    }
}
