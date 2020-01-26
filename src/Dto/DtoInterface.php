<?php

namespace App\Dto;

use Traversable;

interface DtoInterface
{
    /**
     * @return object|object[]
     */
    public function getResource();

    /**
     * @return Traversable|null
     */
    public function getMessages(): ?Traversable;

    /**
     * @param string $message
     * @param array  $context
     *
     * @return mixed
     */
    public function addMessage(string $message, array $context);
}