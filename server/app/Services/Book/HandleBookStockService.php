<?php

namespace App\Services\Book;

use App\Models\Book;
use App\Repositories\Book\BookRepositoryEloquent;

class HandleBookStockService
{
    /**
     * Increases or decreases the available quantity of the book.
     * @param  Book[]  $books
     * @param bool $decrease
     * @return bool
     */
    public function handlesBookStock(array $books, bool $decrease = false): bool
    {
        return (new BookRepositoryEloquent())->handlesBookStock($books, $decrease);
    }
}
