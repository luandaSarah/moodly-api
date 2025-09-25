<?php

namespace App\Repository;

use App\Entity\MoodboardComment;
use App\Dto\Filter\PaginationFilterDto;
use App\Entity\Moodboard;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<MoodboardComment>
 */
class MoodboardCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoodboardComment::class);
    }

    public function countAll(?Moodboard $moodboard = null): int
    {

        if ($moodboard) {
            $query = $this->createQueryBuilder('c')
                ->select('COUNT(c.id)')
                ->andWhere("c.moodboard = :moodboard")
                ->setParameter('moodboard', $moodboard)
                ->getQuery()
                ->getSingleScalarResult();
        } else {
            $query = $this->createQueryBuilder('c')
                ->select('COUNT(c.id)')
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
    public function findPaginate(PaginationFilterDto $filter, ?Moodboard $moodboard = null): array
    {

        $offset = ($filter->getPage() - 1) * $filter->getLimit();
        if ($moodboard) {
            $query = $this->createQueryBuilder('c')
                ->setMaxResults($filter->getLimit())
                ->setFirstResult($offset)
                ->andWhere('c.moodboard = :moodboard')
                ->setParameter('moodboard', $moodboard);
            $total = $this->countAll($moodboard);
        } else {

            $query = $this->createQueryBuilder('c')
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
    //     * @return MoodboardComment[] Returns an array of MoodboardComment objects
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

    //    public function findOneBySomeField($value): ?MoodboardComment
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
