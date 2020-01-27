<?php

namespace App\CommandBus\Query;

use Symfony\Component\Security\Core\User\UserInterface;

class GetTransactionsLogQuery extends GetCollectionQuery
{
    /**
     * @var UserInterface
     */
    private $currentUser;

    /**
     * @return UserInterface
     */
    public function getCurrentUser(): UserInterface
    {
        return $this->currentUser;
    }

    /**
     * @param UserInterface $currentUser
     *
     * @return GetTransactionsLogQuery
     */
    public function setCurrentUser(UserInterface $currentUser): GetTransactionsLogQuery
    {
        $this->currentUser = $currentUser;
        return $this;
    }
}