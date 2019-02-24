<?php

namespace App\Domain\Loan;

use Carbon\Carbon;

class Loan
{
    const MONTH = 1;
    const YEAR = 2;
    const STATUS_PENDING = 0;
    const STATUS_APPROVE = 1;
    const STATUS_TRANSFER = 2;
    const STATUS_COMPLETE = 3;

    /**
     * @var string
     */
    private $contractID;

    /**
     * @var int
     */
    private $durations;


    /**
     * @var Carbon
     */
    private $from_date;


    /**
     * @var Carbon
     */
    private $to_date;

    /**
     * @var int
     */
    private $repaymentFrequency;

    /**
     * @var int
     */
    private $userID;

    /**
     * @var int
     */
    private $arrangementFee;

    /**
     * @var float
     */
    private $interestRate;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $needToPay;

    /**
     * @var int
     */
    private $status;

    public function __construct(
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
    )
    {
        $this->contractID = $contractID;
        $this->durations = $durations;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->repaymentFrequency = $repaymentFrequency;
        $this->userID = $userID;
        $this->arrangementFee = $arrangementFee;
        $this->interestRate = $interestRate;
        $this->total = $total;
        $this->needToPay = $needToPay;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getContractID(): string
    {
        return $this->contractID;
    }

    /**
     * @return int
     */
    public function getDurations(): int
    {
        return $this->durations;
    }

    /**
     * @return Carbon | null
     */
    public function getFromDate(): ?Carbon
    {
        return $this->from_date;
    }

    /**
     * @return Carbon | null
     */
    public function getToDate(): ?Carbon
    {
        return $this->to_date;
    }

    /**
     * @return int
     */
    public function getRepaymentFrequency(): int
    {
        return $this->repaymentFrequency;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @return int
     */
    public function getArrangementFee(): int
    {
        return $this->arrangementFee;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getNeedToPay(): int
    {
        return $this->needToPay;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * @return int
     */
    public function getPaymentFrequency(): int
    {
        switch ($this->getRepaymentFrequency()) {
            case self::MONTH:
                $interest = $this->getNeedToPay() *
                    ($this->getInterestRate()/100 * $this->getFromDate()->diffInMonths($this->getToDate()));
                $paymentFrequency = ($this->getNeedToPay() / $this->getFromDate()->diffInMonths($this->getToDate())) + $interest;
                break;
            case self::YEAR:
                $interest = $this->getNeedToPay() *
                    ($this->getInterestRate()/100 * $this->getFromDate()->diffInYears($this->getToDate()));

                $paymentFrequency = ($this->getNeedToPay() / $this->getFromDate()->diffInYears($this->getToDate())) + $interest;
                break;
            default:
                $paymentFrequency = 0;
                break;
        }

        return $paymentFrequency;
    }

    /**
     * @param int $status
     * @return Loan
     */
    public function setStatus(int $status) : Loan {
        $this->status = $status;
        return $this;
    }


    /**
     * @param Carbon $fromDate
     * @return Loan
     */
    public function setFromDate(Carbon $fromDate) : Loan {
        $this->from_date = $fromDate;
        return $this;
    }

    /**
     * @param Carbon $toDate
     * @return Loan
     */
    public function setToDate(Carbon $toDate) : Loan {
        $this->to_date = $toDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function canApprove() : bool {
        return !in_array($this->status, array(self::STATUS_APPROVE, self::STATUS_TRANSFER, self::STATUS_COMPLETE));
    }

    /**
     * @return bool
     */
    public function canTransfer() : bool {
        return $this->status == self::STATUS_APPROVE;
    }

    /**
     * @return bool
     */
    public function isComplete() : bool {
        return $this->getStatus() == Loan::STATUS_COMPLETE;
    }

    /**
     * @return array
     */
    public function toArray() : array{
        return [
            'contract_id' => $this->getContractID(),
            'durations' => $this->getDurations(),
            'from_date' => !is_null($this->getFromDate()) ? $this->getFromDate()->toDateString() : null,
            'to_date' => !is_null($this->getToDate()) ? $this->getToDate()->toDateString() : null,
            'repayment_frequency' => $this->getRepaymentFrequency(),
            'user_id' => $this->getUserID(),
            'arrangement_fee' => $this->getArrangementFee(),
            'total' => $this->getTotal(),
            'need_to_pay' => $this->getNeedToPay(),
            'interest_rate' =>$this->getInterestRate(),
            'repayment_frequency_pay' => !is_null($this->getFromDate()) && !is_null($this->getToDate()) ? $this->getPaymentFrequency() : 0,
        ];
    }

}
