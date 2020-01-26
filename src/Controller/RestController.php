<?php

namespace App\Controller;

use App\CommandBus\Executable;
use App\Dto\DtoInterface;
use App\Dto\HttpDtoWrapper;
use App\Dto\HttpDtoWrapperInterface;
use App\Dto\MessageBagInterface;
use App\Exception\BadRequestException;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Throwable;

abstract class RestController extends AbstractController
{
    const QUERY_PARAM_PAGE           = 'page';
    const QUERY_PARAM_ITEMS_PER_PAGE = 'itemsPerPage';

    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * RestController constructor.
     *
     * @param CommandBus          $commandBus
     * @param SerializerInterface $serializer
     */
    public function __construct(CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @param Executable $commandOrQuery
     *
     * @return Response
     *
     * @throws Throwable
     */
    protected function exec(Executable $commandOrQuery, int $successCode = HttpDtoWrapperInterface::HTTP_OK): Response
    {
        try {
            /** @var DtoInterface $resource */
            $resource = $this->commandBus->handle($commandOrQuery);
        } catch (InvalidCommandException $e) {
            $violations = $e->getViolations();
            $exception  = new BadRequestException($e->getMessage());
            $context    = [];

            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $context[$violation->getPropertyPath()] = [
                    'reason' => $violation->getMessage(),
                    'value'  => $violation->getInvalidValue(),
                ];
            }

            $exception->addMessage(MessageBagInterface::CONSTRAINTS_FAILED, $context);
            throw $exception;
        }

        $httpResource = new HttpDtoWrapper($resource, HttpDtoWrapperInterface::STATUS_SUCCESS, $successCode);

        return $this->createJsonResponse($httpResource);
    }

    /**
     * @param HttpDtoWrapperInterface $resource
     *
     * @return JsonResponse
     */
    protected function createJsonResponse(HttpDtoWrapperInterface $resource): JsonResponse
    {
        $serialized = $this->serializer->serialize($resource, 'json');

        return new JsonResponse(
            $serialized,
            $resource->getStatusCode(),
            $resource->getHeaders(),
            true
        );
    }
}