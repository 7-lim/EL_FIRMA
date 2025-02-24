<?php

namespace App\Repository;

use App\Entity\Agriculteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Agriculteur>
 *
 * @method Agriculteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agriculteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agriculteur[]    findAll()
 * @method Agriculteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgriculteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agriculteur::class);
    }

    /**
     * Find an agriculteur by their email.
     *
     * @param string $email
     * @return Agriculteur|null
     */
    public function findByEmail(string $email): ?Agriculteur
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Find agriculteurs by their region.
     *
     * @param string $region
     * @return Agriculteur[]
     */
    public function findByRegion(string $region): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.region = :region')
            ->setParameter('region', $region)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find agriculteurs with a specific crop type.
     *
     * @param string $cropType
     * @return Agriculteur[]
     */
    public function findByCropType(string $cropType): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.crops', 'c') // Assuming 'crops' is a relationship in the Agriculteur entity
            ->andWhere('c.type = :cropType')
            ->setParameter('cropType', $cropType)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Count the total number of agriculteurs.
     *
     * @return int
     */
    public function countAgriculteurs(): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Add more custom query methods here as needed
}