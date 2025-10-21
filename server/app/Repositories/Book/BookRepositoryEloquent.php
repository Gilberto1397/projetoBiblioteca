<?php

namespace App\Repositories\Book;

use App\Http\Requests\Book\BookRequest;
use App\Http\Requests\Book\FilteredBooksRequest;
use App\Models\Book;
use App\Models\PublisherBook;
use DateTime;
use DomainException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use PDOException;

class BookRepositoryEloquent implements BookRepository
{
    /**
     * Adds a new book to the database.
     * @param  BookRequest  $bookRequest
     * @throw PDOException|DomainException
     * @return bool
     */
    public function createBook(BookRequest $bookRequest): bool
    {
        try {
            $publicationDate = DateTime::createFromFormat(
                'd/m/Y',
                $bookRequest->publicationDate
            )->format('Y-m-d');

            DB::beginTransaction();

            $book = Book::create([
                'book_title' => $bookRequest->title,
                'book_isbn' => $bookRequest->isbn,
                'book_publication_date' => $publicationDate,
                'book_in_stock' => $bookRequest->inStock,
                'book_author_id' => $bookRequest->author,
                'book_gender_id' => $bookRequest->gender
            ]);

            if (!$book instanceof Book) {
                DB::rollBack();
                return false;
            }

            $publishersBook = [];

            foreach ($bookRequest->publishersList as $publisher) {
                $publishersBook[] = [
                    'book_id' => $book->book_id,
                    'publisher_id' => $publisher
                ];
            }

            $publishersSaved = PublisherBook::insert($publishersBook);

            if (!$publishersSaved) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return $publishersSaved;
        } catch (PDOException $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param  FilteredBooksRequest  $filteredBooksRequest
     * @return Collection|Book[]|array
     */
    public function getFilteredBooks(FilteredBooksRequest $filteredBooksRequest)
    {
        $books = $this->filterBooks($filteredBooksRequest);

        if ($books->doesntExist()) {
            return [];
        }

        return $books->get()->all();
    }

    /**
     * @param  FilteredBooksRequest  $filteredBooksRequest
     * @return Builder
     */
    private function filterBooks(FilteredBooksRequest $filteredBooksRequest): Builder
    {
        $books = Book::query()->with(['author', 'gender']);

        if (!empty($filteredBooksRequest->title)) {
            $books->where('book_title', 'ilike', "%{$filteredBooksRequest->title}%");
        }

        if (!empty($filteredBooksRequest->isbn)) {
            $books->where('book_isbn', $filteredBooksRequest->isbn);
        }

        if (!empty($filteredBooksRequest->author)) {
            $books->where('book_author_id', $filteredBooksRequest->author);
        }

        if (!empty($filteredBooksRequest->gender)) {
            $books->where('book_gender_id', $filteredBooksRequest->gender);
        }

        return $books;
    }

    /**
     * @param  array  $booksIds
     * @return Book[]|null
     * @throws DomainException
     */
    public function GetAvailableBookStock(array $booksIds)
    {
        $books = new Book();

        if (count($booksIds) > 1) {
            $books = $books->whereIn('book_id', $booksIds)->get();
        } else {
            $books = $books->where('book_id', $booksIds)->get();
        }

        if (count($books) === 0) {
            return null;
        }

        return $books->all();
    }

    /**
     * @param  Book[]  $books
     * @param  bool  $decrease
     * @return bool
     */
    public function handlesBookStock(array $books, bool $decrease = false): bool
    {
        try {
            $bindings = [];
            $insertTempTable = 'insert into tempBooksStock (id, book_stock) values';

            foreach ($books as $key => $book) {
                $book_amount_borrowed = (
                $decrease ?
                    $book->book_amount_borrowed - 1 :
                    $book->book_amount_borrowed + 1
                );

                $insertTempTable .= " (:bookId{$key}, :stock{$key})";
                $bindings["bookId{$key}"] = $book->book_id;
                $bindings["stock{$key}"] = $book_amount_borrowed;

                if ($key < count($books) - 1) {
                    $insertTempTable .= ",";
                }
            }

            $queryTempTable = 'CREATE TEMP TABLE tempBooksStock (id INT, book_stock INT)';
            DB::unprepared($queryTempTable);
            DB::insert($insertTempTable, $bindings);

            $queryUpdateBooks = '
                UPDATE books
                SET book_amount_borrowed = tempBooksStock.book_stock
                FROM tempBooksStock
                WHERE books.book_id = tempBooksStock.id;
            ';

            $updatedBooks = DB::unprepared($queryUpdateBooks);
            $dropTemTable = DB::unprepared('drop table tempBooksStock');

            if ($updatedBooks && $dropTemTable) {
                return true;
            }
            return false;
        } catch (\PDOException $PDOException) {
            return false;
        }
    }

    /**
     * Return all registered books.
     * @return Book[]|array
     */
    public function getAllBooks(): array
    {
        $books = Book::all();

        if ($books->count() === 0) {
            return [];
        }

        return $books->all();
    }
}
