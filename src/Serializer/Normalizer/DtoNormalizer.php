<?php

namespace App\Serializer\Normalizer;

use App\Dto\DtoCollectionInterface;
use App\Dto\DtoInterface;
use App\Dto\PaginationDtoCollectionDecorator;
use stdClass;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DtoNormalizer extends ObjectNormalizer
{
    /**
     * @inheritDoc
     *
     * @param DtoInterface|object $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if ($object instanceof DtoCollectionInterface) {
            $result = [];

            if ($object instanceof PaginationDtoCollectionDecorator) {
                $result = [
                    'page'           => $object->getPage(),
                    'items_per_page' => $object->getItemsPerPage(),
                    'total_pages'    => $object->getTotalPages(),
                    'total_results'  => $object->getTotalResults(),
                ];
            }

            foreach ($object as $item) {
                $result['items'][] = $this->serializer->normalize($item);
            }
        } else {
            $resource = $object->getResource();
            $result   = $resource instanceof stdClass ? $resource : $this->serializer->normalize($resource, $format, $context);
        }

        return $result;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof DtoInterface;
    }
}