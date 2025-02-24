<?php

namespace App\Repository;

use App\Entity\Expert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expert>
 *
 * @method Expert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expert[]    findAll()
 * @method Expert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expert::class);
    }

    /**
     * Find an expert by their email.
     *
     * @param string $email
     * @return Expert|null
     */
    public function findByEmail(string $email): ?Expert
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Find experts by their specialization.
     *
     * @param string $specialization
     * @return Expert[]
     */
    public function findBySpecialization(string $specialization): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.specialization = :specialization')
            ->setParameter('specialization', $specialization)
            ->orderBy('e.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts with a minimum rating.
     *
     * @param float $minRating
     * @return Expert[]
     */
    public function findByMinRating(float $minRating): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.rating >= :minRating')
            ->setParameter('minRating', $minRating)
            ->orderBy('e.rating', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Count the total number of experts.
     *
     * @return int
     */
    public function countExperts(): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Find experts available for consultation.
     *
     * @return Expert[]
     */
    public function findAvailableExperts(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.isAvailable = :isAvailable')
            ->setParameter('isAvailable', true)
            ->orderBy('e.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Add more custom query methods here as needed
}