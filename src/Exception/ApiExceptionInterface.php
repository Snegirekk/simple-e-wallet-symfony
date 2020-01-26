<?php

namespace App\Exception;

use App\Dto\MessageBagInterface;

interface ApiExceptionInterface extends MessageBagInterface
{
    /**
     * @return int
     */
    public function getResponseStatusCode(): int;

    /**
     * @param int $code
     * @return ApiException
     */
    public function setResponseStatusCode(int $code): ApiException;
}