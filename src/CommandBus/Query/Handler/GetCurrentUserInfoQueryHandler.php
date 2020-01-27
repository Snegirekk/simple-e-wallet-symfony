<?php

namespace App\CommandBus\Query\Handler;

use App\CommandBus\BaseHandler;
use App\CommandBus\Query\GetCurrentUserInfoQuery;
use App\Dto\BaseDto;
use App\Dto\DtoInterface;
use App\Dto\User\FullUserInfoResource;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;

class GetCurrentUserInfoQueryHandler extends BaseHandler
{
    /**
     * @var AutoMapperInterface
     */
    private $dataMapper;

    /**
     * GetCurrentUserInfoQueryHandler constructor.
     * @param AutoMapperInterface $dataMapper
     */
    public function __construct(AutoMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param GetCurrentUserInfoQuery $query
     * @return DtoInterface
     * @throws UnregisteredMappingException
     */
    public function handle(GetCurrentUserInfoQuery $query): DtoInterface
    {
        $resource = $this->dataMapper->map($query->getCurrentUser(), FullUserInfoResource::class);

        $dto = new BaseDto();
        $dto->setResource($resource);

        return $dto;
    }
}