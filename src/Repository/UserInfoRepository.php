<?php

namespace App\Repository;

use App\Entity\UserInfo;
use App\Dto\Filter\PaginationFilterDto;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<UserInfo>
 */
class UserInfoRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInfo::class);
    }

    public function countAll(): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult(); //renvoie juste un nombre
    }


    /**
     * Summary of findPaginate
     * @param \App\Dto\Filter\PaginationFilterDto $filter
     * @return array{items: mixed, meta: array{pages: float, total: mixed}}
     */
    public function findPaginate(PaginationFilterDto $filter): array 
    {
        $offset = ($filter->getPage() - 1) * $filter->getLimit();
        $query = $this->createQueryBuilder('a') 
            ->setMaxResults($filter->getLimit())
            ->setFirstResult($offset)
           
            ;
            

        $total = $this->countAll();

        return [
            'meta' => [
                'pages' => ceil($total / $filter->getLimit()),
                'total' => $total
            ],
            'items' => $query->getQuery()->getResult(), 

        
        ];
    }

    //    /**
    //     * @return UserInfo[] Returns an array of UserInfo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->join("a.test", 't')
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserInfo
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
