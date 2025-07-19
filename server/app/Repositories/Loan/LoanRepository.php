<?php

namespace App\Repositories\Loan;

use App\Http\Requests\Loan\LoanRequest;
use App\Models\Book;
use App\Models\Loan;

interface LoanRepository
{
    /**
     * Creates a new loan record in the database.
     * @param  LoanRequest  $loanRequest
     * @param  Book[]  $book
     * @return bool
     */
    public function createLoan(LoanRequest $loanRequest, array $book): bool;

    /**
     * Check if the user still has a copy of this book.
     * @param  LoanRequest  $loanRequest
     * @return bool|array
     */
    public function canRentThisBooks(LoanRequest $loanRequest);

    /**
     * Return a book.
     * @param  Loan  $loan
     * @param  array  $book
     * @return bool
     */
    public function endLoan(Loan $loan, array $book): bool;
}
