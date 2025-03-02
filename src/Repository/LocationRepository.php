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
     * 🛠 Check if a terrain is available for new booking (No overlapping dates)
     */
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
     * 🔎 Search locations by price range and sorting
     */
    public function searchLocations(float $minPrix, float $maxPrix, string $sort, string $direction): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.prixLocation BETWEEN :minPrix AND :maxPrix')
            ->setParameter('minPrix', $minPrix)
            ->setParameter('maxPrix', $maxPrix)
            ->orderBy("l.$sort", $direction)
            ->getQuery()
            ->getResult();
    }
    
    /**
     * 🔎 Find Locations by status
     */
    public function findByStatus(string $status): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.statut = :status')
            ->setParameter('status', $status)
            ->orderBy('l.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * 🔎 Find all Locations within a date range
     */
    public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.dateDebut >= :startDate')
            ->andWhere('l.dateFin <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('l.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }



    public function findByPaymentMethod(string $method): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.modePaiement = :method')
            ->setParameter('method', $method)
            ->orderBy('l.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
    






    /**
     * 🆕 Find the latest locations
     */
    public function findLatest(int $limit): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * 🆕 Count total number of locations
     */
    public function countTotal(): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
