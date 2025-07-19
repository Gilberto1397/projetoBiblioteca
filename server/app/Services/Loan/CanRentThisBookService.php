<?php

namespace App\Services\Loan;

use App\Http\Requests\Loan\LoanRequest;
use App\Repositories\Loan\LoanRepositoryEloquent;

class CanRentThisBookService
{
    /**
     * @param  LoanRequest  $loanRequest
     * @return bool|array
     */
    public function canRentThisBooks(LoanRequest $loanRequest)
    {
        return (new LoanRepositoryEloquent())->canRentThisBooks($loanRequest);
    }
}
