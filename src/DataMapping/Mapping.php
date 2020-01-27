<?php

namespace App\DataMapping;

use App\Dto\Transaction\TransactionLogItemResource;
use App\Dto\User\FullUserInfoResource;
use App\Entity\Transaction;
use App\Entity\TransferParticipant;
use App\Entity\User;
use App\Entity\WalletTransferParticipant;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use LogicException;

class Mapping implements AutoMapperConfiguratorInterface
{
    /**
     * @inheritDoc
     */
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config
            ->registerMapping(User::class, FullUserInfoResource::class)
            ->forMember('pointsAmount', function (User $entity): int {
                return $entity->getWallet()->getAmount();
            });

        $config
            ->registerMapping(Transaction::class, TransactionLogItemResource::class)
            ->forMember('description', function (Transaction $entity, AutoMapperInterface $mapper, array $context): string {
                return $this
                    ->getAnotherParticipant($entity, $context)
                    ->getTransferDescription();
            })
            ->forMember('participantName', function (Transaction $entity, AutoMapperInterface $mapper, array $context): string {
                return $this
                    ->getAnotherParticipant($entity, $context)
                    ->getParticipantName();
            })
            ->forMember('type', function (Transaction $entity, AutoMapperInterface $mapper, array $context): string {
                $this->ensureUserProvided($context);
                return $this->getTransactionType($entity, $context['user']);
            });
    }

    /**
     * @param array $context
     */
    private function ensureUserProvided(array $context): void
    {
        if (!array_key_exists('user', $context) || !$context['user'] instanceof User) {
            throw new LogicException('For building a transactions log there is required a user to be provided.');
        }
    }

    /**
     * @param Transaction $transaction
     * @param array       $context
     *
     * @return TransferParticipant
     */
    private function getAnotherParticipant(Transaction $transaction, array $context): TransferParticipant
    {
        $this->ensureUserProvided($context);

        $user            = $context['user'];
        $transactionType = $this->getTransactionType($transaction, $user);

        if ($transactionType === TransactionLogItemResource::TRANSACTION_TYPE_OUTGOING) {
            return $transaction->getTarget();
        } else {
            return $transaction->getSource();
        }
    }

    /**
     * @param Transaction $transaction
     * @param User        $user
     *
     * @return string
     */
    private function getTransactionType(Transaction $transaction, User $user): string
    {
        $transactionSource = $transaction->getSource();
        $transactionTarget = $transaction->getTarget();

        if (
            $transactionSource instanceof WalletTransferParticipant &&
            $transactionSource->getWallet()->getOwner()->getId() === $user->getId()
        ) {
            return TransactionLogItemResource::TRANSACTION_TYPE_OUTGOING;
        } elseif (
            $transactionTarget instanceof WalletTransferParticipant &&
            $transactionTarget->getWallet()->getOwner()->getId() === $user->getId()
        ) {
            return TransactionLogItemResource::TRANSACTION_TYPE_INCOMING;
        } else {
            throw new LogicException('User hasn\'t been involved in this transaction.');
        }
    }
}