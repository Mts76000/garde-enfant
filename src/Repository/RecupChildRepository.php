<?php

namespace App\Repository;

use App\Entity\RecupChild;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecupChild>
 *
 * @method RecupChild|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecupChild|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecupChild[]    findAll()
 * @method RecupChild[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecupChildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecupChild::class);
    }

    //    /**
    //     * @return RecupChild[] Returns an array of RecupChild objects
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

    //    public function findOneBySomeField($value): ?RecupChild
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
