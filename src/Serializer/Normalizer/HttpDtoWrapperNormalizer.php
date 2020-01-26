<?php

namespace App\Serializer\Normalizer;

use App\Dto\HttpDtoWrapperInterface;
use ArrayObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HttpDtoWrapperNormalizer implements NormalizerInterface
{
    /**
     * @var DtoNormalizer
     */
    private $dtoNormalizer;

    /**
     * HttpDtoWrapperNormalizer constructor.
     *
     * @param DtoNormalizer $dtoNormalizer
     */
    public function __construct(DtoNormalizer $dtoNormalizer)
    {
        $this->dtoNormalizer = $dtoNormalizer;
    }

    /**
     * @param HttpDtoWrapperInterface $object
     * @param string|null             $format
     * @param array                   $context
     *
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     *
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $messages = [];

        foreach ($object->getMessages() as $message => $context) {
            $messages[] = [
                'message' => $message,
                'context' => $context,
            ];
        }

        return [
            'status'      => $object->getStatus(),
            'status_code' => $object->getStatusCode(),
            'messages'    => $messages,
            'result'      => $this->dtoNormalizer->normalize($object->getData()),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof HttpDtoWrapperInterface;
    }
}