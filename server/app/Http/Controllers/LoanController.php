<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\EndLoanRequest;
use App\Http\Requests\Loan\LoanRequest;
use App\Services\Loan\CreateLoanService;
use App\Services\Loan\EndLoanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    /**
     * @param  LoanRequest  $loanRequest
     * @param  CreateLoanService  $createLoanService
     * @return JsonResponse
     */
    public function createLoan(LoanRequest $loanRequest, CreateLoanService $createLoanService): JsonResponse
    {
        if (Gate::denies('toLoanOrReturnBook')) {
            return response()->json(['message' => 'Não autorizado a realizar esta ação!', 'error' => true], 401);
        }

        $response = $createLoanService->createLoan($loanRequest);
        return response()->json(
            ['message' => $response->message, 'error' => $response->error], $response->statusCode
        );
    }

    /**
     * @param  EndLoanRequest  $endLoanRequest
     * @param  EndLoanService  $endLoanService
     * @return JsonResponse
     */
    public function endLoan(EndLoanRequest $endLoanRequest, EndLoanService $endLoanService):JsonResponse
    {
        if (Gate::denies('toLoanOrReturnBook')) {
            return response()->json(['message' => 'Não autorizado a realizar esta ação!', 'error' => true], 401);
        }

        $response = $endLoanService->endLoan($endLoanRequest);
        return response()->json(
            ['message' => $response->message, 'error' => $response->error], $response->statusCode
        );
    }
}
