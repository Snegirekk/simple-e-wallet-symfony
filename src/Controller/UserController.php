<?php

namespace App\Controller;

use App\CommandBus\Query\GetCurrentUserInfoQuery;
use App\CommandBus\Query\GetUsersPaginatedListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class UserController extends RestController
{
    private const ITEMS_PER_PAGE = 5;

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws Throwable
     *
     * @Route(name="user.list", path="/user/list", methods={"GET"})
     */
    public function showUsers(Request $request): Response
    {
        $page         = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::ITEMS_PER_PAGE);

        $query = new GetUsersPaginatedListQuery($page, $itemsPerPage);
        $query->setCurrentUser($this->getUser());

        return $this->exec($query);
    }

    /**
     * @return Response
     *
     * @throws Throwable
     *
     * @Route(name="user.profile", path="/user/me", methods={"GET"})
     */
    public function showCurrentUserInfo(): Response
    {
        $query = new GetCurrentUserInfoQuery();
        $query->setCurrentUser($this->getUser());

        return $this->exec($query);
    }
}