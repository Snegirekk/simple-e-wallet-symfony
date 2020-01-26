<?php

namespace App\Exception;

use App\Dto\HttpDtoWrapperInterface;
use App\Dto\MessageBag;
use App\Dto\MessageBagInterface;
use Exception;
use Iterator;

class ApiException extends Exception implements ApiExceptionInterface
{
    /**
     * @var int
     */
    protected $responseStatusCode = HttpDtoWrapperInterface::HTTP_BAD_REQUEST;

    /**
     * @var MessageBagInterface
     */
    protected $messageBag;

    /**
     * ApiException constructor.
     *
     * @param string                   $exceptionMessage
     * @param MessageBagInterface|null $messageBag
     */
    public function __construct(string $exceptionMessage, ?MessageBagInterface $messageBag = null)
    {
        parent::__construct($exceptionMessage);

        $this->messageBag = $messageBag ?? new MessageBag();
    }

    /**
     * @return int
     */
    public function getResponseStatusCode(): int
    {
        return $this->responseStatusCode;
    }

    /**
     * @param int $code
     *
     * @return ApiException
     */
    public function setResponseStatusCode(int $code): ApiException
    {
        $this->responseStatusCode = $code;
        return $this;
    }

    /**
     * @return Iterator
     */
    public function getMessages(): Iterator
    {
        return $this->messageBag->getMessages();
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return ApiExceptionInterface
     */
    public function addMessage(string $message, array $context = []): MessageBagInterface
    {
        $this->messageBag->addMessage($message, $context);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->messageBag->count();
    }
}