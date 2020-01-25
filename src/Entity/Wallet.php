<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="wallets")
 */
class Wallet
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
     * @var WalletTransferParticipant
     *
     * @ORM\OneToOne(targetEntity="App\Entity\WalletTransferParticipant", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="cascade")
     */
    private $transferParticipant;

    /**
     * Wallet constructor.
     * @param WalletTransferParticipant $transferParticipant
     */
    public function __construct(WalletTransferParticipant $transferParticipant)
    {
        $this->transferParticipant = $transferParticipant;
        $transferParticipant->setWallet($this);
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
     * @return Wallet
     */
    public function setAmount(int $amount): Wallet
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return WalletTransferParticipant
     */
    public function getTransferParticipant(): WalletTransferParticipant
    {
        return $this->transferParticipant;
    }
}