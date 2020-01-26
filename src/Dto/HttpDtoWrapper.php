<?php

namespace App\Dto;

use Traversable;

class HttpDtoWrapper implements HttpDtoWrapperInterface
{
    /**
     * @var DtoInterface
     */
    private $dto;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * HttpDtoWrapper constructor.
     *
     * @param DtoInterface $dto
     * @param string       $status
     * @param int          $statusCode
     */
    public function __construct(DtoInterface $dto, string $status, int $statusCode)
    {
        $this->dto        = $dto;
        $this->status     = $status;
        $this->statusCode = $statusCode;
    }

    /**
     * @return object
     */
    public function getData()
    {
        return $this->dto;
    }

    /**
     * @return Traversable|null
     */
    public function getMessages(): ?Traversable
    {
        return $this->dto->getMessages();
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return HttpDtoWrapperInterface
     */
    public function addMessage(string $message, array $context = []): HttpDtoWrapperInterface
    {
        $this->dto->addMessage($message, $context);
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param string $status
     *
     * @return HttpDtoWrapperInterface
     */
    public function setStatus(string $status): HttpDtoWrapperInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param int $statusCode
     *
     * @return HttpDtoWrapperInterface
     */
    public function setStatusCode(int $statusCode): HttpDtoWrapperInterface
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return HttpDtoWrapperInterface
     */
    public function addHeader(string $key, string $value): HttpDtoWrapperInterface
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function removeHeader(string $key): HttpDtoWrapperInterface
    {
        unset($this->headers[$key]);
        return $this;
    }
}