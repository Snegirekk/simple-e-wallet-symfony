<?php

namespace App\Serializer\Normalizer;

use App\Dto\HttpDtoWrapperInterface;
use ArrayObject;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class HttpDtoWrapperNormalizer extends ObjectNormalizer
{
    /**
     * @param HttpDtoWrapperInterface $object
     * @param string|null             $format
     * @param array                   $context
     *
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $messages = [];

        foreach ($object->getMessages() as $message => $messageContext) {
            $messages[] = [
                'message' => $message,
                'context' => $messageContext,
            ];
        }

        return [
            'status'      => $object->getStatus(),
            'status_code' => $object->getStatusCode(),
            'messages'    => $messages,
            'result'      => $this->serializer->normalize($object->getData(), $format, $context),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof HttpDtoWrapperInterface;
    }
}