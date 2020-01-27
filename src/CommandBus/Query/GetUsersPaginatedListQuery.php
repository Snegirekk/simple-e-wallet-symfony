<?php

namespace App\CommandBus\Query;

use Symfony\Component\Security\Core\User\UserInterface;

class GetUsersPaginatedListQuery extends GetCollectionQuery
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
     * @return GetUsersPaginatedListQuery
     */
    public function setCurrentUser(UserInterface $currentUser): GetUsersPaginatedListQuery
    {
        $this->currentUser = $currentUser;
        return $this;
    }
}