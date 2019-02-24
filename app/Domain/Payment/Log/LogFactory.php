<?php

namespace App\Domain\Payment\Log;

class LogFactory
{

    /**
     * @param  string $contractID
     * @param  int $total
     * @param  string $source
     * @return Log
     */
    public function make(
        string $contractID,
        int $total,
        string $source
    ): Log
    {
        return new Log($contractID, $total, $source);
    }

    /**
     * @param  string $contractID
     * @param  int $total
     * @param  string $source
     * @return Log
     */
    public function init(
        string $contractID,
        int $total,
        string $source
    ): Log
    {
        return $this->make($contractID, $total, $source);
    }

    /**
     * @param \App\PaymentLog $eloquent
     * @return Log
     */
    public function makeByEloquent(\App\PaymentLog $eloquent): Log
    {
        $contractID = $eloquent->contract_id;
        $total = $eloquent->total;
        $source = $eloquent->source;
        return $this->make($contractID, $total, $source);
    }
}