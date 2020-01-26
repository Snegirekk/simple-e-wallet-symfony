<?php

namespace App\Dto;

use Traversable;

class PaginationDtoCollectionDecorator implements DtoCollectionInterface
{
    /**
     * @var DtoCollectionInterface
     */
    private $collection;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * PageDto constructor.
     *
     * @param DtoCollectionInterface $collection
     * @param int                    $page
     * @param int                    $itemsPerPage
     * @param int                    $totalPages
     */
    public function __construct(DtoCollectionInterface $collection, int $page, int $itemsPerPage, int $totalPages)
    {
        $this->collection   = $collection;
        $this->page         = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalPages   = $totalPages;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @inheritDoc
     */
    public function getItemsType(): string
    {
        return $this->collection->getItemsType();
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * @inheritDoc
     */
    public function getResource()
    {
        return $this->collection->getResource();
    }

    /**
     * @inheritDoc
     */
    public function getMessages(): ?Traversable
    {
        return $this->collection->getMessages();
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return $this
     */
    public function addMessage(string $message, array $context)
    {
        $this->collection->addMessage($message, $context);
        return $this;
    }
}