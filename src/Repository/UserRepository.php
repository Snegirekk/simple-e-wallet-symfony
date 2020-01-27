<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends BaseEntityRepository
{
    use PaginatorAwareTrait;

    /**
     * @param array $providedUsers
     * @param int   $page
     * @param int   $itemsPerPage
     * @param array $filters
     *
     * @return Paginator
     */
    public function getUsersPaginatedExceptProvided(array $providedUsers, int $page, int $itemsPerPage, array $filters = []): Paginator
    {
        $ids = [];

        foreach ($providedUsers as $providedUser) {
            $ids[] = $providedUser->getId();
        }

        $qb = $this->createQueryBuilder('u');
        $qb->andWhere($qb->expr()->notIn('u.id', $ids));

        foreach ($filters as $field => $value) {
            $qb
                ->andWhere(sprintf('u.%1$s = :%1$s', $field))
                ->setParameter($field, $value);
        }

        return $this->getPaginator($qb->getQuery(), $page, $itemsPerPage);
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return User::class;
    }
}