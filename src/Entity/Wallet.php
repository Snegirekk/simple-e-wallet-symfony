<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @var UserInterface
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="wallet")
     */
    private $owner;

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

    /**
     * @return UserInterface
     */
    public function getOwner(): UserInterface
    {
        return $this->owner;
    }

    /**
     * @param UserInterface $owner
     * @return Wallet
     */
    public function setOwner(UserInterface $owner): Wallet
    {
        $this->owner = $owner;
        return $this;
    }
}