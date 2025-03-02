<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

    public function findLatest(int $limit): array
{
    return $this->createQueryBuilder('t')
        ->orderBy('t.id', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function countTotal(): int
{
    return $this->createQueryBuilder('t')
        ->select('COUNT(t.id)')
        ->getQuery()
        ->getSingleScalarResult();
}




public function countTerrainsByStatus(string $status): int
{
   return $this->createQueryBuilder('t')
       ->select('COUNT(t.id)')
       ->where('t.statut = :status')
       ->setParameter('status', $status)
       ->getQuery()
       ->getSingleScalarResult();
}




}
