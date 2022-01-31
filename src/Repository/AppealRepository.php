<?php

namespace App\Repository;

use App\Entity\Appeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Appeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appeal[]    findAll()
 * @method Appeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appeal::class);
    }

    public function getFilteredQuery($status, $customer, $phone)
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC');

        if (isset($status)) {
            $qb->andWhere('a.status = :status')
            ->setParameter('status', $status);
        }
        if ($phone) {
            $qb->andWhere('a.phone = :phone')
            ->setParameter('phone', $phone);
        }
        if ($customer) {
            $qb->andWhere('a.customer = :customer')
            ->setParameter('customer', $customer);
        }
        $qb->orderBy('a.id', 'DESC');

        return $qb->getQuery();
    }

    public function getAllQuery()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();
    }

    public function getPaginatedPages($query, $currentPage = 1, $limit = 3)
    {
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($limit * ($currentPage - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function getDistinctField($field)
    {
        return $this->createQueryBuilder('a')
            ->select('a.' . $field)
            ->andWhere('a.' . $field . ' IS NOT NULL')
            ->groupBy('a.' . $field)
            ->getQuery()
            ->execute();
    }

    public function findOneLatest(): ?Appeal
    {
        return $this->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
    // /**
    //  * @return Appeal[] Returns an array of Appeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appeal
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
