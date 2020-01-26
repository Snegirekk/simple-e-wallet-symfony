<?php

namespace App\Dto;

class BaseDto implements DtoInterface
{
    use MessagesAwareTrait;

    /**
     * @var object
     */
    private $resource;

    /**
     * BaseDto constructor.
     */
    public function __construct()
    {
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