<?php

namespace App\Services\Loan;

use App\Http\Requests\Loan\LoanRequest;
use App\Repositories\Loan\LoanRepository;
use App\Services\Book\GetAvailableBookStockService;

class CreateLoanService
{
    private LoanRepository $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    /**
     * @param  LoanRequest  $loanRequest
     * @return object
     */
    public function createLoan(LoanRequest $loanRequest): object
    {
        try {
            $response = (object)[
                'message' => 'Livros emprestados com sucesso!',
                'statusCode' => 201,
                'error' => false
            ];

            $canRentThisBook = $this->canRentBooks($loanRequest);

            if ($canRentThisBook !== true) {
                return $canRentThisBook;
            }

            $bookAvaibleStock = $this->booksAvaibleStocks($loanRequest->bookList);

            $loanSaved = $this->loanRepository->createLoan($loanRequest, $bookAvaibleStock);

            if (!$loanSaved) {
                $response = (object)[
                    'message' => 'Falha ao emprestar livro',
                    'statusCode' => 500,
                    'error' => true
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

    /**
     * @param $loanRequest
     * @return object|true
     */
    private function canRentBooks($loanRequest)
    {
        $canRentThisBook = (new CanRentThisBookService())->canRentThisBooks($loanRequest);

        if ($canRentThisBook !== true && count($canRentThisBook) > 0) {
            $bookNames = 'O usuário ainda possui uma cópia dos seguintes livros:';

            foreach ($canRentThisBook as $key => $book) {
                $bookNames .= " $book->book_title";
                if ($key < count($canRentThisBook) - 1) {
                    $bookNames .= ',';
                }
            }

            return (object)[
                'message' => $bookNames,
                'statusCode' => 500,
                'error' => true
            ];
        }
        return true;
    }

    /**
     * @param array $booksIds
     * @return array
     * @throws \DomainException
     */
    private function booksAvaibleStocks($booksIds) //todo dizer o nome de todos sem estoque
    {
        $bookAvaibleStock = (new GetAvailableBookStockService())->availableBookStock($booksIds);
        $books = [];

        foreach ($bookAvaibleStock as $bookStock) {
            if ($bookStock->avaibleStock === 0) {
                throw new \DomainException("O livro {$bookStock->book->book_title} não possui estoque disponível!");
            }
            $books[] = $bookStock->book;
        }
        return $books;
    }
}
