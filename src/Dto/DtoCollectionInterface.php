<?php

namespace App\Dto;

use Countable;
use IteratorAggregate;

interface DtoCollectionInterface extends DtoInterface, IteratorAggregate, Countable
{
    /**
     * @return string
     */
    public function getItemsType(): string;
}