<?php

namespace App\CommandBus\Query\Handler;

use App\CommandBus\BaseHandler;
use App\CommandBus\Query\GetTransactionsLogQuery;
use App\Dto\DtoCollection;
use App\Dto\DtoInterface;
use App\Dto\PaginationDtoCollectionDecorator;
use App\Dto\Transaction\TransactionLogItemResource;
use App\Repository\TransactionRepository;
use AutoMapperPlus\AutoMapperInterface;

class GetTransactionsLogQueryHandler extends BaseHandler
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var AutoMapperInterface
     */
    private $dataMapper;

    /**
     * GetTransactionsLogQueryHandler constructor.
     *
     * @param TransactionRepository $transactionRepository
     * @param AutoMapperInterface   $dataMapper
     */
    public function __construct(TransactionRepository $transactionRepository, AutoMapperInterface $dataMapper)
    {
        $this->transactionRepository = $transactionRepository;
        $this->dataMapper            = $dataMapper;
    }

    /**
     * @param GetTransactionsLogQuery $query
     * @return DtoInterface
     */
    public function handle(GetTransactionsLogQuery $query): DtoInterface
    {
        $currentUser  = $query->getCurrentUser();
        $page         = $query->getPage();
        $itemsPerPage = $query->getItemsPerPage();

        $collection       = new DtoCollection(TransactionLogItemResource::class);
        $transactionsPage = $this->transactionRepository->getTransactionsPaginatedByUser($currentUser, $page, $itemsPerPage);

        $resourceArray = $this->dataMapper->mapMultiple(
            $transactionsPage,
            TransactionLogItemResource::class,
            ['user' => $currentUser]
        );

        array_map(function (TransactionLogItemResource $logItem) use ($collection) {
            $collection->add($logItem);
        }, $resourceArray);

        return new PaginationDtoCollectionDecorator($collection, $page, $itemsPerPage, $transactionsPage->count());
    }
}