<?php

namespace App\Repository;

use App\Entity\Encadreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Encadreur>
 */
class EncadreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Encadreur::class);
    }

    //    /**
    //     * @return Encadreur[] Returns an array of Encadreur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function encadreurCount(): int
       {
           return $this->createQueryBuilder('e')
               ->select('Count(e.id)')
               ->getQuery()
               ->getSingleScalarResult();
           ;
       }
}
