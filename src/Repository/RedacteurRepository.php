<?php

namespace App\Repository;

use App\Entity\Redacteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Redacteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Redacteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Redacteur[]    findAll()
 * @method Redacteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RedacteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redacteur::class);
    }

    // /**
    //  * @return Redacteur[] Returns an array of Redacteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Redacteur
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
