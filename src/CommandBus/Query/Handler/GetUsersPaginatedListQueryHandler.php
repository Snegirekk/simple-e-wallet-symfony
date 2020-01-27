<?php

namespace App\CommandBus\Query\Handler;

use App\CommandBus\BaseHandler;
use App\CommandBus\Query\GetUsersPaginatedListQuery;
use App\Dto\DtoCollection;
use App\Dto\DtoInterface;
use App\Dto\PaginationDtoCollectionDecorator;
use App\Dto\User\PublicUserInfoResource;
use App\Repository\UserRepository;
use AutoMapperPlus\AutoMapperInterface;

class GetUsersPaginatedListQueryHandler extends BaseHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AutoMapperInterface
     */
    private $dataMapper;

    /**
     * GetUsersPaginatedListQueryHandler constructor.
     *
     * @param UserRepository      $userRepository
     * @param AutoMapperInterface $dataMapper
     */
    public function __construct(UserRepository $userRepository, AutoMapperInterface $dataMapper)
    {
        $this->userRepository = $userRepository;
        $this->dataMapper     = $dataMapper;
    }

    /**
     * @param GetUsersPaginatedListQuery $query
     * @return DtoInterface
     */
    public function handle(GetUsersPaginatedListQuery $query): DtoInterface
    {
        $page         = $query->getPage();
        $itemsPerPage = $query->getItemsPerPage();

        $collection = new DtoCollection(PublicUserInfoResource::class);
        $usersPage  = $this->userRepository->getUsersPaginatedExceptProvided([$query->getCurrentUser()], $page, $itemsPerPage);

        $resourceArray = $this->dataMapper->mapMultiple($usersPage, PublicUserInfoResource::class);

        array_map(function (PublicUserInfoResource $resource) use ($collection) {
            $collection->add($resource);
        }, $resourceArray);

        return new PaginationDtoCollectionDecorator($collection, $page, $itemsPerPage, $usersPage->count());
    }
}