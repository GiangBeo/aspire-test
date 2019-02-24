<?php

namespace App\Http\Controllers;

use App\Component\LoanComponent;
use App\Component\PaymentComponent;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * @var LoanComponent
     */
    private $loanComponent;

    /**
     * @var PaymentComponent
     */
    private $paymentComponent;

    /**
     * @param LoanComponent $loanComponent
     * @param PaymentComponent $paymentComponent
     */
    public function __construct(
        LoanComponent $loanComponent,
        PaymentComponent $paymentComponent
    )
    {
        $this->loanComponent = $loanComponent;
        $this->paymentComponent = $paymentComponent;
    }

    public function createLoan(Request $request)
    {

        try {
            $loan = $this->loanComponent->createLoan(
                $request->user()->id,
                $request->input("total"),
                $request->input("durations"),
                $request->input("repayment_frequency")
            );
            return response()->json(
                [
                    'error' => "",
                    'status_code' => 200,
                    'data' => $loan->toArray()
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => $exception->getMessage(),
                    'status_code' => 422,
                    'data' => []
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    public function approveLoan(Request $request)
    {

        try {
            $loan = $this->loanComponent->approveLoan(
                $request->input("contract_id")
            );

            return response()->json(
                [
                    'error' => "",
                    'status_code' => 200,
                    'data' => $loan->toArray()
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => $exception->getMessage(),
                    'status_code' => 422,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }


    public function transferLoan(Request $request)
    {

        try {
            $loan = $this->loanComponent->transferLoan(
                $request->input("contract_id")
            );

            return response()->json(
                [
                    'error' => "",
                    'status_code' => 200,
                    'data' => $loan->toArray()
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => $exception->getMessage(),
                    'status_code' => 422,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }


    public function rejectLoan(Request $request)
    {

        try {
            $loan = $this->loanComponent->rejectLoan(
                $request->input("contract_id")
            );

            return response()->json(
                [
                    'error' => "",
                    'status_code' => 200,
                    'data' => $loan->toArray()
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => $exception->getMessage(),
                    'status_code' => 422,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    public function addPayment(Request $request)
    {
        try {
            $this->paymentComponent->paymentContract(
                $request->input("contract_id"),
                $request->input("source"),
                $request->input("total")
            );

            return response()->json(
                [
                    'error' => "",
                    'status_code' => 200,
                    'data' => []
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json(
                [
                    'error' => $exception->getMessage(),
                    'status_code' => 422,
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
    }
}
