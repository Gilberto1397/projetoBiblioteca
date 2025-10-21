<?php

namespace App\Services\Loan;

use App\Http\Requests\Loan\EndLoanRequest;
use App\Repositories\Loan\LoanRepositoryEloquent;
use App\Services\Book\GetAvailableBookStockService;

class EndLoanService
{
    /**
     * @param  EndLoanRequest  $endLoanRequest
     * @throws \DomainException
     * @return object
     */
    public function endLoan(EndLoanRequest $endLoanRequest): object
    {
        try {
            $response = (object)[
                'message' => 'Livro devolvido com sucesso!',
                'statusCode' => 201,
                'error' => false
            ];

            $loanSituation = (new VerifiyLoanService())->verifyLoan($endLoanRequest->loan);

            if ($loanSituation->situation > 0) {
                throw new \DomainException($loanSituation->message);
            }

            $booksList = [];

            foreach ($loanSituation->loan->books->all() as $book) {
                $booksList[]['id'] = $book->book_id;
            }

            $bookAvaibleStock = (new GetAvailableBookStockService())->availableBookStock($booksList);

            $bookNames = 'Os seguintes livros estão sem estoque:';
            $withoutStock = false;
            $booksList = [];

            foreach ($bookAvaibleStock as $key => $bookSituation) {
                $booksList[] = $bookSituation->book;

                if ($bookSituation->book->book_amount_borrowed == 0) {
                    $withoutStock = true;
                    $bookNames .= " $bookSituation->book->book_title";

                    if ($key < count($bookAvaibleStock) - 1) {
                        $bookNames .= ',';
                    }
                }
            }

            if ($withoutStock) {
                throw new \DomainException($bookNames);
            }

            $updateLoan = (new LoanRepositoryEloquent())->endLoan($loanSituation->loan, $booksList);

            if (!$updateLoan) {
                $response = (object)[
                    'message' => 'Falha ao devolver livro!',
                    'statusCode' => 500,
                    'error' => false
                ];
            }
            return $response;

        } catch (\DomainException $domainException) {
            return (object)[
                'message' => $domainException->getMessage(),
                'statusCode' => 500,
                'error' => true
            ];
        }
    }
}
