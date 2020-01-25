<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class WalletTransferParticipant extends TransferParticipant
{
    /**
     * @var Wallet
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Wallet")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    private $wallet;

    /**
     * @inheritDoc
     */
    public function getTransferDescription(): string
    {
        return 'Internal points transfer.';
    }

    /**
     * @return Wallet
     */
    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     * @return WalletTransferParticipant
     */
    public function setWallet(Wallet $wallet): WalletTransferParticipant
    {
        $this->wallet = $wallet;
        return $this;
    }

}