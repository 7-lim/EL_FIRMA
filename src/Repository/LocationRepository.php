<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Terrain;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * Save a Location entity.
     */
    public function save(Location $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }



    public function isTerrainAvailable(Terrain $terrain, \DateTime $dateDebut, \DateTime $dateFin): bool
    {
        $qb = $this->createQueryBuilder('l')
            ->where('l.terrain = :terrain')
            ->andWhere('(l.dateDebut < :dateFin AND l.dateFin > :dateDebut)')
            ->setParameter('terrain', $terrain)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery();

        return empty($qb->getResult());
    }




    /**
     * Remove a Location entity.
     */
    public function remove(Location $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Find Locations by status.
     */
    public function findByStatus(string $status): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.Statut = :status')
            ->setParameter('status', $status)
            ->orderBy('l.DateDebut', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all Locations within a date range.
     */
    public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.DateDebut >= :startDate')
            ->andWhere('l.DateFin <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('l.DateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function findLatest(int $limit): array
{
    return $this->createQueryBuilder('l')
        ->orderBy('l.id', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function countTotal(): int
{
    return $this->createQueryBuilder('l')
        ->select('COUNT(l.id)')
        ->getQuery()
        ->getSingleScalarResult();
}



public function searchLocations($query, $sort, $direction)
{
    $qb = $this->createQueryBuilder('l')
        ->leftJoin('l.utilisateur', 'u')
        ->addSelect('u');

    if ($query) {
        $qb->where('u.nom LIKE :query OR u.prenom LIKE :query')
           ->setParameter('query', '%' . $query . '%');
    }

    $qb->orderBy('l.' . $sort, $direction);

    return $qb->getQuery()->getResult();
}

}