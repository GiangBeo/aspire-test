<?php

namespace App\Component;

use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanFactory;
use App\Domain\Loan\LoanRepository;
use Carbon\Carbon;

class LoanComponent
{
    /**
     * @var LoanFactory
     */
    private $loanFactory;

    /**
     * @var LoanRepository
     */
    private $loanRepository;

    /**
     * @param LoanFactory $loanFactory
     * @param LoanRepository $loanRepository
     */
    public function __construct(LoanFactory $loanFactory, LoanRepository $loanRepository)
    {
        $this->loanFactory = $loanFactory;
        $this->loanRepository = $loanRepository;
    }

    /**
     * @param int $userID
     * @param int $total
     * @param int $durations
     * @param int $repaymentFrequency
     * @return Loan
     * @throws \Exception
     */
    public function createLoan(int $userID, int $total, int $durations, int $repaymentFrequency): Loan
    {
        $listLoan = $this->loanRepository->findLoanByUser($userID);
        $loanContractID = $listLoan->filter(function(Loan $loan){
            return in_array($loan->getStatus(), array(Loan::STATUS_APPROVE, Loan::STATUS_TRANSFER));
        });

        if ($loanContractID->count() > 0){
            throw new \Exception("You have contract not yet to complete");
        }

        $contractID = uniqid();
        $arrangementFee = 1000;
        $interRest = 0.85;
        $loan = $this->loanFactory->make(
            $contractID,
            $durations,
            null,
            null,
            $repaymentFrequency,
            $userID,
            $arrangementFee,
            $interRest,
            $total,
            $total + $arrangementFee,
            Loan::STATUS_PENDING
        );

        $this->loanRepository->create($loan);

        return $loan;
    }


    /**
     * @param int $userID
     * @param string $contractID
     * @return Loan
     * @throws \Exception
     */
    public function approveLoan(int $userID, string $contractID): Loan
    {

        $loan = $this->loanRepository->findLoan($contractID, $userID);

        if ($loan->canApprove()) {
            $loan = $loan->setStatus(Loan::STATUS_APPROVE)->setFromDate(Carbon::now());

            switch ($loan->getRepaymentFrequency()) {
                case Loan::MONTH :
                    {
                        $loan = $loan->setToDate(Carbon::now()->addMonth($loan->getDurations()));
                        break;
                    }
                case Loan::YEAR :
                    {
                        $loan = $loan->setToDate(Carbon::now()->addYear($loan->getDurations()));
                        break;
                    }
            }
        }
        $this->loanRepository->update($loan);

        $listLoan = $this->loanRepository->findLoanByUser($userID);

        $loanContractID = $listLoan->filter(function(Loan $loan){
            return $loan->getStatus() == Loan::STATUS_PENDING;
        })->map(function(Loan $loan){
            return $loan->getContractID();
        });

        $this->loanRepository->remove($loanContractID);
        return $loan;
    }
}