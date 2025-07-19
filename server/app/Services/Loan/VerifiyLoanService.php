<?php

namespace App\Services\Loan;

use App\Models\Loan;

class VerifiyLoanService
{
    CONST SITUATION_ACTIVE = 0;
    CONST SITUATION_NO_FOUNDED = 1;
    CONST SITUATION_CLOSED = 2;

    /**
     * Checks the status of a loan, which may be active, not found or closed.
     * @param  int  $loanId
     * @return object
     */
    public function verifyLoan(int $loanId): object
    {
        $loan = Loan::find($loanId);

        $loanSituation = (object)[
            'situation' => self::SITUATION_ACTIVE,
            'message' => 'Empréstimo ativo.',
            'loan' => $loan
        ];

        if (empty($loan)) {
            $loanSituation->situation = self::SITUATION_NO_FOUNDED;
            $loanSituation->message = 'Empréstimo de livro não encontrado.';
        }

        if (!empty($loan->loan_true_return_date)) {
            $returnDate = \DateTime::createFromFormat('Y-m-d', $loan->loan_true_return_date)
                ->format('d/m/Y');

            $loanSituation->situation = self::SITUATION_CLOSED;
            $loanSituation->message = "Empréstimo finalizado no dia {$returnDate}.";
        }

        if ($loanSituation->situation != self::SITUATION_ACTIVE) {
            unset($loanSituation->loan);
        }

        return $loanSituation;
    }
}
