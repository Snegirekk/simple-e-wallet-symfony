<?php

namespace App\Exception;

use App\Dto\HttpDtoWrapperInterface;

class UnauthorizedException extends ApiException
{
    protected $responseStatusCode = HttpDtoWrapperInterface::HTTP_UNAUTHORIZED;
}