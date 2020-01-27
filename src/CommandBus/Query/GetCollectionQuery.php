<?php

namespace App\CommandBus\Query;

use App\CommandBus\Executable;

abstract class GetCollectionQuery implements Executable
{
    /**
     * @var int|null
     */
    protected $page;

    /**
     * @var int|null
     */
    protected $itemsPerPage;

    /**
     * @var array
     */
    protected $filters;

    /**
     * GetCollectionQuery constructor.
     *
     * @param int|null $page
     * @param int|null $itemsPerPage
     * @param array    $filters
     */
    public function __construct($page, $itemsPerPage, array $filters = [])
    {
        $this->page         = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->filters      = $filters;
    }

    /**
     * @return int|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int|null
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}