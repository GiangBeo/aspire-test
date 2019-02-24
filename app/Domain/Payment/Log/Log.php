<?php

namespace App\Domain\Payment\Log;

class Log
{
    /**
     * @var string
     */
    private $contractID;

    /**
     * @var int
     */
    private $total;

    /**
     * @var string
     */
    private $source;

    /**
     * @param  string $contractID
     * @param  int $total
     * @param  string $source
     */
    public function __construct(
        string $contractID,
        int $total,
        string $source
    )
    {
        $this->contractID = $contractID;
        $this->total = $total;
        $this->source = $source;
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
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
}