<?php

namespace App\Repository;

use App\Entity\Moodboard;
use App\Entity\MoodboardLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoodboardLike>
 */
class MoodboardLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoodboardLike::class);
    }


    public function countLikes(Moodboard $moodboard): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->andWhere("l.moodboard = :user")
            ->setParameter('user', $moodboard)
            ->getQuery()
            ->getSingleScalarResult(); //renvoie juste un nombre
    }
//    /**
//     * @return MoodboardLike[] Returns an array of MoodboardLike objects
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

//    public function findOneBySomeField($value): ?MoodboardLike
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
