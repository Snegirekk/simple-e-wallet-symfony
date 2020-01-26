<?php

namespace App\Exception;

use App\Dto\HttpDtoWrapperInterface;

class InvalidEntityException extends ApiException
{
    protected $responseStatusCode = HttpDtoWrapperInterface::HTTP_UNPROCESSABLE_ENTITY;
}