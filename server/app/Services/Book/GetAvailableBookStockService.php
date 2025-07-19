<?php

namespace App\Services\Book;

use App\Repositories\Book\BookRepositoryEloquent;
use DomainException;

class GetAvailableBookStockService
{
    /**
     * Book stock available.
     * @param  array  $booksIds
     * @return array
     * @throws DomainException
     */
    public function availableBookStock(array $booksIds): array
    {
        $listIdBooks = [];

        foreach ($booksIds as $bookId) {
            $listIdBooks[] = $bookId['id'];
        }
        $books = (new BookRepositoryEloquent())->GetAvailableBookStock($listIdBooks);

        if (is_null($books)) {
            throw new DomainException('Falha ao recuperar estoque de livros!');
        }
        $foundedBooks = [];

        foreach ($books as $book) {
            $foundedBooks[] = (object)[
                'avaibleStock' => $book->book_in_stock - $book->book_amount_borrowed,
                'book' => $book
            ];
        }
        return $foundedBooks;
    }
}
