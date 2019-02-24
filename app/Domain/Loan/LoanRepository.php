<?php

namespace App\Domain\Loan;

use Illuminate\Support\Collection;

class LoanRepository
{
    /**
     * @var LoanFactory
     */
    private $loanFactory;

    /**
     * @param  LoanFactory $loanFactory
     */
    public function __construct(LoanFactory $loanFactory)
    {
        $this->loanFactory = $loanFactory;
    }

    /**
     * @param  Loan $loan
     * @return int
     */
    public function create(Loan $loan): int
    {
        $loan = \App\Loan::create([
            'contract_id' => $loan->getContractID(),
            'durations' => $loan->getDurations(),
            'from_date' => !is_null($loan->getFromDate()) ? $loan->getFromDate()->toDateString() : null,
            'to_date' => !is_null($loan->getToDate()) ? $loan->getToDate()->toDateString() : null,
            'repayment_frequency' => $loan->getRepaymentFrequency(),
            'user_id' => $loan->getUserID(),
            'arrangement_fee' => $loan->getArrangementFee(),
            'total' => $loan->getTotal(),
            'need_to_pay' => $loan->getNeedToPay(),
            'interest_rate' => $loan->getInterestRate(),
            'status' => $loan->getStatus(),
            'repayment_frequency_pay' => !is_null($loan->getFromDate()) && !is_null($loan->getToDate()) ? $loan->getPaymentFrequency() : 0,
        ]);

        return $loan->id;
    }

    /**
     * @param  string $contractID
     * @param  int $userID
     * @return Loan
     */
    public function findLoan(string $contractID, int $userID): Loan
    {
        $loan = \App\Loan::query()->where('contract_id', $contractID)->where("user_id", $userID)->first();

        if (is_null($loan)) {
            new \Exception("Contract not found");
        }

        return $this->loanFactory->makeByEloquent($loan);
    }

    /**
     * @param  Loan $loan
     * @return int
     */
    public function update(Loan $loan): int
    {
        $loan = \App\Loan::query()->where("contract_id", $loan->getContractID())->update([
            'durations' => $loan->getDurations(),
            'from_date' => !is_null($loan->getFromDate()) ? $loan->getFromDate()->toDateString() : null,
            'to_date' => !is_null($loan->getToDate()) ? $loan->getToDate()->toDateString() : null,
            'repayment_frequency' => $loan->getRepaymentFrequency(),
            'user_id' => $loan->getUserID(),
            'arrangement_fee' => $loan->getArrangementFee(),
            'total' => $loan->getTotal(),
            'need_to_pay' => $loan->getNeedToPay(),
            'interest_rate' => $loan->getInterestRate(),
            'status' => $loan->getStatus(),
            'repayment_frequency_pay' => !is_null($loan->getFromDate()) && !is_null($loan->getToDate()) ? $loan->getPaymentFrequency() : 0,
        ]);

        return $loan;
    }

    /**
     * @param  int $userID
     * @return Collection | Loan[]
     * @throws \Exception
     */
    public function findLoanByUser(int $userID): Collection
    {
        $loan = \App\Loan::query()->where("user_id", $userID)->get();

        if (is_null($loan)) {
            throw new \Exception("Contract not found");
        }

        return collect($loan)->map(function (\App\Loan $loanEloquent) {
            return $this->loanFactory->makeByEloquent($loanEloquent);
        });
    }


    /**
     * @param  Collection $contractIDs
     * @return void
     */
    public function remove(Collection $contractIDs): void
    {
        \App\Loan::query()->whereIn("contract_id", $contractIDs->toArray())->delete();

    }
}