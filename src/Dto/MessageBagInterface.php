<?php

namespace App\Dto;

use Countable;
use Iterator;

interface MessageBagInterface extends Countable
{
    const RESOURCE_NOT_FOUND = 'Resource not found';
    const BAD_REQUEST_DATA   = 'Can not parse the request data';
    const PAGE_NOT_FOUND     = 'Page not found';
    const NOTHING_MATCHES    = 'No results found';
    const ROUTE_NOT_FOUND    = 'Route not found';
    const CREATION_ERROR     = 'Resource creation error';
    const EDIT_ERROR         = 'Resource modifying error';
    const CONSTRAINTS_FAILED = 'Validation error';
    const INTERNAL_ERROR     = 'Internal server error';
    const ENTITY_OMITTED     = 'The entity has been omitted';
    const ACCESS_DENIED      = 'Access denied';

    /**
     * @return Iterator
     */
    public function getMessages(): Iterator;

    /**
     * @param string $message
     * @param array  $context
     *
     * @return MessageBagInterface
     */
    public function addMessage(string $message, array $context = []): MessageBagInterface;
}