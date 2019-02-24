<?php

namespace App\Component;

use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanRepository;
use App\Domain\Payment\Log\Log;
use App\Domain\Payment\Log\LogFactory;
use App\Domain\Payment\Log\LogRepository;

class PaymentComponent
{
    /**
     * @var LogFactory
     */
    private $logFactory;

    /**
     * @var LogRepository
     */
    private $logRepository;

    /**
     * @var LoanRepository
     */
    private $loanRepository;

    /**
     * @param LogFactory $logFactory
     * @param LogRepository $logRepository
     * @param LoanRepository $loanRepository
     */
    public function __construct(LogFactory $logFactory, LogRepository $logRepository, LoanRepository $loanRepository)
    {
        $this->logFactory = $logFactory;
        $this->logRepository = $logRepository;
        $this->loanRepository = $loanRepository;
    }

    /**
     * @param string $contractID
     * @param string $source
     * @param int $total
     * @return int
     * @throws \Exception
     */
    public function paymentContract(string $contractID, string $source, int $total): int
    {
        $loan = $this->loanRepository->findLoanByContractID($contractID);

        if ($loan->isComplete() || !$loan->isTransfer()) {
            throw new \Exception(trans("loan.can_not_payment"));
        }

        $payment = $this->logFactory->make($contractID, $total, $source);

        $this->logRepository->create($payment);

        $listLogs = $this->logRepository->findLogByContractID($contractID);
        $totalPayment = $listLogs->sum(function (Log $log) {
            return $log->getTotal();
        });

        if ($totalPayment >= $loan->getPaymentFrequency() * $loan->getDurations()) {
            $loan = $loan->setStatus(Loan::STATUS_COMPLETE);
            $this->loanRepository->update($loan);
        }

        return $totalPayment;

    }
}