<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Moodboard;
use App\Dto\Filter\PaginationFilterDto;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Moodboard>
 */
class MoodboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moodboard::class);
    }

    public function countAll(?User $user = null): int
    {

        if ($user) {
            $query =   $this->createQueryBuilder('m')
                ->select('COUNT(m.id)')
                ->andWhere("m.user = :user")
                ->setParameter('user', $user)
                ->getQuery()
                ->getSingleScalarResult();
        } else {
            $query = $this->createQueryBuilder('m')
                ->select('COUNT(m.id)')
                ->getQuery()
                ->getSingleScalarResult(); //renvoie juste un nombre

        }


        return $query;
    }


    /**
     * Summary of findPaginate
     * @param \App\Dto\Filter\PaginationFilterDto $filter
     * @return array{items: mixed, meta: array{pages: float, total: mixed}}
     */
    public function findPaginate(PaginationFilterDto $filter, ?User $user = null): array
    {

        $offset = ($filter->getPage() - 1) * $filter->getLimit();
        if ($user) {
            $query = $this->createQueryBuilder('m')
                ->setMaxResults($filter->getLimit())
                ->setFirstResult($offset)
                ->andWhere('m.user = :user')
                ->setParameter('user', $user);
            $total = $this->countAll($user);
        } else {


            $query = $this->createQueryBuilder('m')
                ->setMaxResults($filter->getLimit())
                ->setFirstResult($offset);
            $total = $this->countAll();
        }

        return [
            'meta' => [
                'pages' => ceil($total / $filter->getLimit()),
                'total' => $total
            ],
            'items' => $query->getQuery()->getResult(),


        ];
    }

    //    /**
    //     * @return Moodboard[] Returns an array of Moodboard objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Moodboard
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
