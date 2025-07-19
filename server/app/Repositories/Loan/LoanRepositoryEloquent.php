<?php

namespace App\Repositories\Loan;

use App\Http\Requests\Loan\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanBook;
use App\Services\Book\HandleBookStockService;
use Illuminate\Support\Facades\DB;
use PDOException;

class LoanRepositoryEloquent implements LoanRepository
{
    /**
     * Creates a new loan record in the database.
     * @param  LoanRequest  $loanRequest
     * @param  Book[]  $book
     * @return bool
     */
    public function createLoan(LoanRequest $loanRequest, array $books): bool
    {
        try {
            DB::beginTransaction();
            $stockSaved = (new HandleBookStockService())->handlesBookStock($books);

            if (!$stockSaved) {
                DB::rollBack();
                return false;
            }

            $savedLoan = Loan::create([
                'loan_date' => date('Y-m-d'),
                'loan_expected_return_date' => date('Y-m-d', strtotime('+3 days')),
                'loan_user_id' => $loanRequest->user,
            ]);

            if (!$savedLoan instanceof Loan) {
                DB::rollBack();
                return false;
            }

            $loansBooks = [];

            foreach ($loanRequest->bookList as $book) {
                $loansBooks[] = [
                    'loans_books_loan_id' => $savedLoan->loan_id,
                    'loans_books_book_id' => $book['id'],
                ];
            }

            if (!LoanBook::insert($loansBooks)) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;
        } catch (\PDOException $PDOException) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Check if the user still has a copy of this book.
     * @param  LoanRequest  $loanRequest
     * @return bool|array
     */
    public function canRentThisBooks(LoanRequest $loanRequest)
    {
        $listBookIds = [];

        foreach ($loanRequest->bookList as $book) {
            $listBookIds[] = $book['id'];
        }

        $loanBooks = Loan::query()
            ->select('books.*')
            ->join('loans_books', 'loans_books_loan_id', '=', 'loan_id')
            ->join('books', 'book_id', '=', 'loans_books_book_id')
            ->where('loan_user_id', $loanRequest->user)
            ->where('loan_true_return_date', null);

        if (count($listBookIds) > 1) {
            $loanBooks->whereIn('loans_books_book_id', $listBookIds);
        } else {
            $loanBooks->where('loans_books_book_id', $listBookIds);
        }

        if ($loanBooks->count() == 0) {
            return true;
        }
        $loanBooks = $loanBooks->get();
        return Book::hydrate($loanBooks->toArray())->all();
    }

    /**
     * Return a book.
     * @param  Loan  $loan
     * @param  array  $book
     * @return bool
     */
    public function endLoan(Loan $loan, array $book): bool
    {
        try {
            DB::beginTransaction();

            $loan->loan_true_return_date = date('Y-m-d', strtotime('now'));
            $loan->loan_forfeit = 10;

            if (!$loan->save()) {
                DB::rollBack();
                return false;
            }

            if (!(new HandleBookStockService())->handlesBookStock($book, true)) {
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;
        } catch (PDOException $PDOException) {
            DB::rollBack();
            return false;
        }
    }
}
