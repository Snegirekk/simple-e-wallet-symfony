<?php

namespace App\CommandBus\Query;

use App\CommandBus\Executable;
use Symfony\Component\Security\Core\User\UserInterface;

class GetCurrentUserInfoQuery implements Executable
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
     * @return GetCurrentUserInfoQuery
     */
    public function setCurrentUser(UserInterface $currentUser): GetCurrentUserInfoQuery
    {
        $this->currentUser = $currentUser;
        return $this;
    }

}