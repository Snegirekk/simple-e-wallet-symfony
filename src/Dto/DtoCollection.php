<?php

namespace App\Dto;

use Exception;
use InvalidArgumentException;

class DtoCollection implements FillableDtoCollectionInterface
{
    use MessagesAwareTrait;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var string
     */
    private $itemsType;

    /**
     * PageDto constructor.
     *
     * @param string $itemsType
     */
    public function __construct(string $itemsType)
    {
        $this->itemsType  = $itemsType;
        $this->messageBag = new MessageBag();
    }

    /**
     * @return object|object[]
     *
     * @throws Exception
     */
    public function getResource()
    {
        return $this->getIterator();
    }

    /**
     * @return string
     */
    public function getItemsType(): string
    {
        return $this->itemsType;
    }

    /**
     * @inheritDoc
     */
    public function add($item): FillableDtoCollectionInterface
    {
        if (!$item instanceof $this->itemsType) {
            throw new InvalidArgumentException(sprintf('Can not add "%s" to collection of type "%s".', get_class($item), $this->itemsType));
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove($item): FillableDtoCollectionInterface
    {
        $index = array_search($item, $this->items);

        if ($index) {
            unset($this->items[$index]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        foreach ($this->items as $i => $item) {
            yield $i => $item;
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->items);
    }
}