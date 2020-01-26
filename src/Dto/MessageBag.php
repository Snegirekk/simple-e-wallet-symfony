<?php

namespace App\Dto;

use Generator;
use Iterator;

class MessageBag implements MessageBagInterface
{
    /**
     * @var array
     */
    private $messages = [];

    /**
     * @return Generator|Iterator
     */
    public function getMessages(): Iterator
    {
        foreach ($this->messages as $message) {
            $title   = key($message);
            $context = $message[$title];
            yield $title => $context;
        }
    }

    /**
     * @inheritDoc
     */
    public function addMessage(string $message, array $context = []): MessageBagInterface
    {
        $this->messages[] = [$message => $context];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->messages);
    }
}