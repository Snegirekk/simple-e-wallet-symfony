<?php

namespace App\Dto;

interface FillableDtoCollectionInterface extends DtoCollectionInterface
{
    /**
     * @param object $item
     *
     * @return FillableDtoCollectionInterface
     */
    public function add($item): FillableDtoCollectionInterface;

    /**
     * @param object $item
     *
     * @return FillableDtoCollectionInterface
     */
    public function remove($item): FillableDtoCollectionInterface;
}