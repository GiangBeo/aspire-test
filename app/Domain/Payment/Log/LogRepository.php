<?php
namespace App\Domain\Payment\Log;

use Illuminate\Support\Collection;

class LogRepository{
    /**
     * @var LogFactory
     */
    private $logFactory;

    /**
     * @param  LogFactory $logFactory
     */
    public function __construct(LogFactory $logFactory)
    {
        $this->logFactory = $logFactory;
    }

    /**
     * @param  Log $log
     * @return string
     */
    public function create(Log $log): string
    {
        \App\PaymentLog::create([
            'contract_id' => $log->getContractID(),
            'total' => $log->getTotal(),
            'source' => $log->getSource()
        ]);

        return $log->getContractID();
    }

    /**
     * @param  string $contractID
     * @return Collection | Log[]
     * @throws \Exception
     */
    public function findLogByContractID(string $contractID): Collection
    {
        $paymentLog = \App\PaymentLog::query()->where("contract_id", $contractID)->get();

        return collect($paymentLog)->map(function (\App\PaymentLog $paymentLogEloquent) {
            return $this->logFactory->makeByEloquent($paymentLogEloquent);
        });
    }
}