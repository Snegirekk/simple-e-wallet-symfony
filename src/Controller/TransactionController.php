<?php

namespace App\Controller;

use App\CommandBus\Command\TransferPointsBetweenUsersCommand;
use App\CommandBus\Query\GetTransactionsLogQuery;
use App\Dto\Transaction\InternalTransferResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class TransactionController extends RestController
{
    private const ITEMS_PER_PAGE = 10;

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws Throwable
     *
     * @Route(name="transaction.transfer_points_between_users", path="/transaction", methods={"POST"})
     */
    public function transferPointsBetweenUsers(Request $request): Response
    {
        $transferResource = $this->serializer->deserialize($request->getContent(), InternalTransferResource::class, 'json');

        $command = new TransferPointsBetweenUsersCommand();
        $command
            ->setCurrentUser($this->getUser())
            ->setTransferResource($transferResource);

        return $this->exec($command);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws Throwable
     *
     * @Route(name="transaction.log", path="/transaction/log", methods={"GET"})
     */
    public function showTransactionsLog(Request $request): Response
    {
        $page         = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::ITEMS_PER_PAGE);

        $query = new GetTransactionsLogQuery($page, $itemsPerPage);
        $query->setCurrentUser($this->getUser());

        return $this->exec($query);
    }
}