<?php

namespace App\Dto\Transaction;

class TransactionLogItemResource
{
    public const TRANSACTION_TYPE_INCOMING = 'incoming';
    public const TRANSACTION_TYPE_OUTGOING = 'outgoing';

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var mixed
     */
    private $description;

    /**
     * @var mixed
     */
    private $participantName;

    /**
     * @var mixed
     */
    private $type;

    /**
     * @var mixed
     */
    private $amount;

    /**
     * @var mixed
     */
    private $occurredAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TransactionLogItemResource
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return TransactionLogItemResource
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParticipantName()
    {
        return $this->participantName;
    }

    /**
     * @param mixed $participantName
     * @return TransactionLogItemResource
     */
    public function setParticipantName($participantName)
    {
        $this->participantName = $participantName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return TransactionLogItemResource
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return TransactionLogItemResource
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOccurredAt()
    {
        return $this->occurredAt;
    }

    /**
     * @param mixed $occurredAt
     * @return TransactionLogItemResource
     */
    public function setOccurredAt($occurredAt)
    {
        $this->occurredAt = $occurredAt;
        return $this;
    }
}