<?php

namespace App\Repository;

use App\Entity\Souscrire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Souscrire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Souscrire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Souscrire[]    findAll()
 * @method Souscrire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SouscrireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Souscrire::class);
    }

    // /**
    //  * @return Souscrire[] Returns an array of Souscrire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Souscrire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
