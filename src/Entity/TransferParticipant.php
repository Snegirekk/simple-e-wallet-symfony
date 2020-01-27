<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="transfer_participants")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn("type")
 * @ORM\DiscriminatorMap({
 *   "wallet": "App\Entity\WalletTransferParticipant"
 * })
 */
abstract class TransferParticipant
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    abstract public function getParticipantName(): string;

    /**
     * @return string
     */
    abstract public function getTransferDescription(): string;
}