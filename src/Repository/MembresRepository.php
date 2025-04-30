<?php

namespace App\Repository;

use App\Entity\Membres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membres>
 */
class MembresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membres::class);
    }

    //    /**
    //     * @return Membres[] Returns an array of Membres objects
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

    public function membreCount(): int
    {
        return $this->createQueryBuilder('m')
            ->select('Count(m.id)')
            ->getQuery()
            ->getSingleScalarResult();;
    }

    public function countNewMembres(): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.isnew = :isnew')
            ->setParameter('isnew', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countNewMembresByDahira($dahira): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.isnew = :isnew')
            ->andWhere('m.dahiras = :dahira')
            ->setParameter('isnew', true)
            ->setParameter('dahira', $dahira)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countMembresByDahira($dahira): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->Where('m.dahiras = :dahira')
            ->setParameter('dahira', $dahira)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
