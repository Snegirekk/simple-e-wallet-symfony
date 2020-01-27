<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

trait PaginatorAwareTrait
{
    /**
     * @param Query $query
     * @param int   $page
     * @param int   $itemsPerPage
     * @param bool  $fetchJoinCollection
     * @return Paginator
     */
    protected function getPaginator(Query $query, int $page, int $itemsPerPage, bool $fetchJoinCollection = true): Paginator
    {
        $firstResult = ($page - 1) * $itemsPerPage;

        /** @var Query $qb */
        $query
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage);

        return new Paginator($query, $fetchJoinCollection);
    }
}