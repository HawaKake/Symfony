<?php

namespace App\Repository;

use App\Entity\Dettes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dettes>
 */
class DettesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dettes::class);
    }

    //    /**
    //     * @return Dettes[] Returns an array of Dettes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dettes
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function findByStatut(array $statuts)
    {
        $qb = $this->createQueryBuilder('d');

        if (!empty($statuts)) {
            $qb->andWhere('d.statut IN (:statuts)')
               ->setParameter('statuts', $statuts);
        }

        return $qb->getQuery()->getResult();
    }

}
