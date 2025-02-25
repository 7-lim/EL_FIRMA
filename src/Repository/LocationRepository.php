<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

}
