<?php

namespace App\Exception;

use App\Dto\HttpDtoWrapperInterface;

class PageNotFoundException extends ApiException
{
    protected $responseStatusCode = HttpDtoWrapperInterface::HTTP_NOT_FOUND;
}