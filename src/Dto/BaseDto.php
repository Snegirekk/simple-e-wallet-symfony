<?php

namespace App\Dto;

use stdClass;

class BaseDto implements DtoInterface
{
    use MessagesAwareTrait;

    /**
     * @var object
     */
    private $resource;

    /**
     * BaseDto constructor.
     * @param object|null $resource
     */
    public function __construct(?object $resource = null)
    {
        $this->resource   = $resource ?? new stdClass();
        $this->messageBag = new MessageBag();
    }

    /**
     * @return object
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param object $resource
     * @return BaseDto
     */
    public function setResource(object $resource): BaseDto
    {
        $this->resource = $resource;
        return $this;
    }
}