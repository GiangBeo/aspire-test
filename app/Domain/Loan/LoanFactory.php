<?php

namespace App\Domain\Loan;

use Carbon\Carbon;

class LoanFactory
{
    public function make(
        $contractID,
        $durations,
        $from_date = null,
        $to_date = null,
        $repaymentFrequency,
        $userID,
        $arrangementFee,
        $interestRate,
        $total,
        $needToPay,
        $status
    ): Loan
    {
        if(!is_null($from_date)){
            $from_date = Carbon::createFromFormat("Y-m-d H:i:s", $from_date);
        }
        if(!is_null($to_date)){
            $to_date = Carbon::createFromFormat("Y-m-d H:i:s", $to_date);
        }

        return new Loan(
            $contractID,
            $durations,
            $from_date,
            $to_date,
            $repaymentFrequency,
            $userID,
            $arrangementFee,
            $interestRate,
            $total,
            $needToPay,
            $status
        );
    }

    public function makeByEloquent(\App\Loan $eloquent): Loan
    {
        $contractID = $eloquent->contract_id;
        $durations = $eloquent->durations;
        $from_date = $eloquent->from_date;
        $to_date = $eloquent->to_date;
        $repaymentFrequency = $eloquent->repayment_frequency;
        $userID = $eloquent->user_id;
        $arrangementFee = $eloquent->arrangement_fee;
        $interestRate = $eloquent->interest_rate;
        $total = $eloquent->total;
        $needToPay = $eloquent->need_to_pay;
        $status = $eloquent->status;

        return $this->make(
            $contractID,
            $durations,
            $from_date,
            $to_date,
            $repaymentFrequency,
            $userID,
            $arrangementFee,
            $interestRate,
            $total,
            $needToPay,
            $status
        );
    }
}