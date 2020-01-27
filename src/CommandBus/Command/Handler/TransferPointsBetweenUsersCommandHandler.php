<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\BaseHandler;
use App\CommandBus\Command\TransferPointsBetweenUsersCommand;
use App\Dto\BaseDto;
use App\Dto\DtoInterface;
use App\Dto\Transaction\TransactionLogItemResource;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Exception\BadRequestException;
use App\Repository\UserRepository;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class TransferPointsBetweenUsersCommandHandler extends BaseHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AutoMapperInterface
     */
    private $dataMapper;

    /**
     * TransferPointsBetweenUsersCommandHandler constructor.
     *
     * @param UserRepository         $userRepository
     * @param EntityManagerInterface $entityManager
     * @param AutoMapperInterface    $dataMapper
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, AutoMapperInterface $dataMapper)
    {
        $this->userRepository = $userRepository;
        $this->entityManager  = $entityManager;
        $this->dataMapper     = $dataMapper;
    }

    /**
     * @param TransferPointsBetweenUsersCommand $command
     *
     * @return DtoInterface
     *
     * @throws Throwable
     * @throws ConnectionException
     */
    public function handle(TransferPointsBetweenUsersCommand $command): DtoInterface
    {
        $transferResource = $command->getTransferResource();
        $transferAmount   = $transferResource->getAmount();
        $currentUser      = $command->getCurrentUser();

        $this->abortIfInsufficientFunds($transferAmount, $currentUser->getWallet());

        $targetUser   = $this->findTargetUser($transferResource->getTargetUserId(), $currentUser);
        $sourceWallet = $currentUser->getWallet();
        $targetWallet = $targetUser->getWallet();

        $this->entityManager->getConnection()->beginTransaction();

        try {
            $transaction = new Transaction();
            $transaction
                ->setAmount($transferAmount)
                ->setSource($currentUser->getWallet()->getTransferParticipant())
                ->setTarget($targetUser->getWallet()->getTransferParticipant());

            $sourceWallet->setAmount($sourceWallet->getAmount() - $transferAmount);
            $targetWallet->setAmount($targetWallet->getAmount() + $transferAmount);

            $this->entityManager->persist($transaction);
            $this->entityManager->flush();

            $transactionLogItem = $this->dataMapper->map(
                $transaction,
                TransactionLogItemResource::class,
                ['user' => $currentUser]
            );

            $this->entityManager->getConnection()->commit();
        } catch (Throwable $error) {
            $this->entityManager->getConnection()->rollBack();
            throw $error;
        }

        return new BaseDto($transactionLogItem);
    }

    /**
     * @param int    $transferAmount
     * @param Wallet $wallet
     *
     * @throws BadRequestException
     */
    private function abortIfInsufficientFunds(int $transferAmount, Wallet $wallet): void
    {
        if ($wallet->getAmount() < $transferAmount) {
            $message = 'Insufficient funds.';

            $exception = new BadRequestException($message);
            $exception->addMessage($message, [
                'transfer_amount' => $transferAmount,
                'wallet_amount'   => $wallet->getAmount(),
            ]);

            throw $exception;
        }
    }

    /**
     * @param string $targetUserId
     *
     * @param User $currentUser
     *
     * @return User
     *
     * @throws BadRequestException
     */
    private function findTargetUser(string $targetUserId, User $currentUser): User
    {
        /** @var User $targetUser */
        $targetUser = $this->userRepository->find($targetUserId);

        if (!$targetUser || $targetUser->getId() === $currentUser->getId()) {
            $message = 'Target user not found.';

            $exception = new BadRequestException($message);
            $exception->addMessage($message, [
                'user_id' => $targetUserId,
            ]);

            throw $exception;
        }

        return $targetUser;
    }
}