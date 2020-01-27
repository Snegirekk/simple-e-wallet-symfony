<?php

namespace App\CommandBus\Command;

use App\CommandBus\Executable;
use App\Dto\Transaction\InternalTransferResource;
use App\Entity\User;

class TransferPointsBetweenUsersCommand implements Executable
{
    /**
     * @var User
     */
    private $currentUser;

    /**
     * @var InternalTransferResource
     */
    private $transferResource;

    /**
     * @return User
     */
    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }

    /**
     * @param User $currentUser
     * @return TransferPointsBetweenUsersCommand
     */
    public function setCurrentUser(User $currentUser): TransferPointsBetweenUsersCommand
    {
        $this->currentUser = $currentUser;
        return $this;
    }

    /**
     * @return InternalTransferResource
     */
    public function getTransferResource(): InternalTransferResource
    {
        return $this->transferResource;
    }

    /**
     * @param InternalTransferResource $transferResource
     * @return TransferPointsBetweenUsersCommand
     */
    public function setTransferResource(InternalTransferResource $transferResource): TransferPointsBetweenUsersCommand
    {
        $this->transferResource = $transferResource;
        return $this;
    }

}