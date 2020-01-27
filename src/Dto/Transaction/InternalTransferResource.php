<?php

namespace App\Dto\Transaction;

class InternalTransferResource
{
    /**
     * @var mixed
     */
    private $targetUserId;

    /**
     * @var mixed
     */
    private $amount;

    /**
     * @return mixed
     */
    public function getTargetUserId()
    {
        return $this->targetUserId;
    }

    /**
     * @param mixed $targetUserId
     * @return InternalTransferResource
     */
    public function setTargetUserId($targetUserId)
    {
        $this->targetUserId = $targetUserId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return InternalTransferResource
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
}