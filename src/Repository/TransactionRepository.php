<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TransactionRepository extends BaseEntityRepository
{
    use PaginatorAwareTrait;

    /**
     * @param User  $user
     * @param int   $page
     * @param int   $itemsPerPage
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTransactionsPaginatedByUser(User $user, int $page, int $itemsPerPage, array $filters = []): Paginator
    {
        $transferParticipant = $user->getWallet()->getTransferParticipant();

        $qb = $this->createQueryBuilder('t');
        $qb
            ->join('t.source', 'source')
            ->join('t.target', 'target')

            ->andWhere(
                $qb->expr()->orX(
                    'source = :participant',
                    'target = :participant'
                )
            )
            ->setParameter('participant', $transferParticipant)

            ->addOrderBy('t.occurredAt', 'DESC');

        foreach ($filters as $field => $value) {
            $qb
                ->andWhere(sprintf('t.%1$s = :%1$s', $field))
                ->setParameter($field, $value);
        }

        return $this->getPaginator($qb->getQuery(), $page, $itemsPerPage);
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Transaction::class;
    }
}