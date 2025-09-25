<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\Relationship;
use App\Dto\Filter\PaginationFilterDto;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Relationship>
 */
class RelationshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Relationship::class);
    }


    public function countAll(User $user, string $followType): int
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->andWhere("r.$followType = :user")
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult(); //renvoie juste un nombre
    }


    // public function findUser()
    // {
    //     return $this->createQueryBuilder('u')
    //     ->select('')
    // }
    /**
     * Summary of findPaginate
     * @param \App\Dto\Filter\PaginationFilterDto $filter
     * @return array{items: mixed, meta: array{pages: float, total: mixed}}
     */
    public function findPaginateFollowers(PaginationFilterDto $filter, User $user): array
    {
        $offset = ($filter->getPage() - 1) * $filter->getLimit();
        $query = $this->createQueryBuilder('r')
            ->setMaxResults($filter->getLimit())
            ->setFirstResult($offset)
            ->andWhere('r.followed = :user')
            ->setParameter('user', $user);

        $total = $this->countAll($user, "followed");

        return [
            'meta' => [
                'pages' => ceil($total / $filter->getLimit()),
                'total' => $total
            ],
            'items' => $query->getQuery()->getResult(),
        ];
    }


    public function findPaginateFollowing(PaginationFilterDto $filter, User $user): array
    {
        $offset = ($filter->getPage() - 1) * $filter->getLimit();
        $query = $this->createQueryBuilder('r')
            ->setMaxResults($filter->getLimit())
            ->setFirstResult($offset)
            ->andWhere('r.following = :user')
            ->setParameter('user', $user);

        $total = $this->countAll($user, "following");

        return [
            'meta' => [
                'pages' => ceil($total / $filter->getLimit()),
                'total' => $total
            ],
            'items' => $query->getQuery()->getResult(),
        ];
    }
    //    /**
    //     * @return Relationship[] Returns an array of Relationship objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Relationship
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
