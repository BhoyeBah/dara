<?php

namespace App\Repository;

use App\Entity\Reunion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reunion>
 */
class ReunionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reunion::class);
    }

    /**
     * Récupérer le nombre de réunions par Dahira dans un mois donné
     *
     * @param int $mois Le mois (1 = janvier, 12 = décembre)
     * @param int $annee L'année (ex : 2024)
     * @return array Un tableau contenant le nombre de réunions par Dahira
     */
    public function countReunionsParDahira(int $mois, int $annee)
    {
        $dateDebut = new \DateTime("$annee-$mois-01");
        $dateFin = (clone $dateDebut)->modify('last day of this month')->setTime(23, 59, 59);

        return $this->createQueryBuilder('r')
            ->select('d.id AS dahira_id', 'COUNT(r.id) AS nombre_reunions')
            ->innerJoin('r.dahiras', 'd')
            ->where('r.date BETWEEN :dateDebut AND :dateFin')
            ->groupBy('d.id')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Reunion[] Returns an array of Reunion objects
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

    public function reunionCount(): int
    {
        return $this->createQueryBuilder('r')
            ->select('Count(r.id)')
            ->getQuery()
            ->getSingleScalarResult();;
    }

    public function countReunionByDahira($dahira): int
    {
        return (int) $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->Where('r.dahiras = :dahira')
            ->setParameter('dahira', $dahira)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
