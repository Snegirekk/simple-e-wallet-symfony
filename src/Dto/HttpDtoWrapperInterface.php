<?php

namespace App\Dto;

use Traversable;

interface HttpDtoWrapperInterface
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_REDIRECT = 'redirect';

    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;

    const HTTP_MULTIPLE_CHOICE = 300;
    const HTTP_NOT_MODIFIED = 304;

    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_CONFLICT = 409;
    const HTTP_UNPROCESSABLE_ENTITY = 422;

    const HTTP_SERVER_ERROR = 500;

    /**
     * @return object
     */
    public function getData();

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return int
     */
    public function getStatusCode(): int;

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

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param string $key
     * @param string $value
     *
     * @return HttpDtoWrapperInterface
     */
    public function addHeader(string $key, string $value): HttpDtoWrapperInterface;

    /**
     * @param string $key
     *
     * @return HttpDtoWrapperInterface
     */
    public function removeHeader(string $key): HttpDtoWrapperInterface;
}