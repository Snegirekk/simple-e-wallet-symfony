<?php

namespace App\Dto;

use Traversable;

trait MessagesAwareTrait
{
    /**
     * @var MessageBagInterface
     */
    private $messageBag;

    /**
     * @return Traversable|null
     */
    public function getMessages(): ?Traversable
    {
        return $this->messageBag->getMessages();
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function addMessage(string $message, array $context = [])
    {
        $this->messageBag->addMessage($message, $context);
        return $this;
    }
}