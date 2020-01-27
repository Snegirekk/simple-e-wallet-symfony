<?php

namespace App\EventListener;

use App\Dto\BaseDto;
use App\Dto\HttpDtoWrapper;
use App\Dto\HttpDtoWrapperInterface;
use App\Dto\MessageBagInterface;
use App\Exception\ApiExceptionInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ExceptionListener
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $environment;

    /**
     * ExceptionListener constructor.
     *
     * @param SerializerInterface $serializer
     * @param LoggerInterface     $logger
     * @param string              $environment
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger, string $environment)
    {
        $this->serializer  = $serializer;
        $this->logger      = $logger;
        $this->environment = $environment;
    }

    /**
     * @param ExceptionEvent $event
     *
     * @throws Throwable
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception    = $event->getThrowable();
        $extraHeaders = [];

        $errorDto = new BaseDto();

        if ($exception instanceof ApiExceptionInterface) {
            $statusCode = $exception->getResponseStatusCode();

            foreach ($exception->getMessages() as $message => $context) {
                $errorDto->addMessage($message, $context);
            }

            $this->logger->error(sprintf('API Error: "%s"', $exception->getMessage()), iterator_to_array($errorDto->getMessages()));
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $message    = strpos($exception->getMessage(), 'object not found') === false ? $exception->getMessage() : MessageBagInterface::RESOURCE_NOT_FOUND;

            $errorDto->addMessage($message);

            $extraHeaders = $exception->getHeaders();

            $this->logger->warning(sprintf('API HTTP Exception: "%s"', $exception->getMessage()), $exception->getTrace());
        } else {
            if ($this->environment === 'prod') {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $errorDto->addMessage(MessageBagInterface::INTERNAL_ERROR);
            } else {
                throw $exception;
            }

            $this->logger->critical(sprintf('API Critical: "%s"', $exception->getMessage()), $exception->getTrace());
        }

        $resource = new HttpDtoWrapper(
            $errorDto,
            HttpDtoWrapperInterface::STATUS_ERROR,
            $statusCode
        );

        foreach ($extraHeaders as $header => $value) {
            $resource->addHeader($header, $value);
        }

        $serialized = $this->serializer->serialize($resource, 'json');

        $response = new JsonResponse(
            $serialized,
            $resource->getStatusCode(),
            $resource->getHeaders(),
            true
        );

        $event->setResponse($response);
    }
}