<?php

namespace App\Repositories\Book;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\FilteredBooksRequest;
use App\Models\Book;

interface BookRepository
{
    public function createBook(BookRequest $bookRequest): bool;

    public function getFilteredBooks(FilteredBooksRequest $filteredBooksRequest);

    public function GetAvailableBookStock(array $booksIds);

    public function handlesBookStock(array $book, bool $decrease = false): bool;

    /**
     * Return all registered books.
     * @return Book[]|array
     */
    public function getAllBooks(): array;
}
