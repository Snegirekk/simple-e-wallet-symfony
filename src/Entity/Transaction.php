<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="transactions")
 */
class Transaction
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", options={"unsigned": true})
     */
    private $amount;

    /**
     * @var TransferParticipant
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TransferParticipant")
     */
    private $source;

    /**
     * @var TransferParticipant
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\TransferParticipant")
     */
    private $target;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $occurredAt;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->occurredAt = new DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Transaction
     */
    public function setAmount(int $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return TransferParticipant
     */
    public function getSource(): TransferParticipant
    {
        return $this->source;
    }

    /**
     * @param TransferParticipant $source
     * @return Transaction
     */
    public function setSource(TransferParticipant $source): Transaction
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return TransferParticipant
     */
    public function getTarget(): TransferParticipant
    {
        return $this->target;
    }

    /**
     * @param TransferParticipant $target
     * @return Transaction
     */
    public function setTarget(TransferParticipant $target): Transaction
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getOccurredAt(): DateTime
    {
        return $this->occurredAt;
    }
}