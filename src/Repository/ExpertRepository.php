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
     * Find an expert by email.
     */
    public function findByEmail(string $email): ?Expert
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all active experts.
     */
    public function findActiveExperts(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.actif = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts who are part of a discussion.
     */
    public function findExpertsInDiscussions(): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.discussions', 'd')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find experts by ticket involvement.
     */
    public function findExpertsByTicket(int $ticketId): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.tickets', 't')
            ->andWhere('t.id = :ticketId')
            ->setParameter('ticketId', $ticketId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Save an expert to the database.
     */
    public function save(Expert $expert, bool $flush = true): void
    {
        $this->getEntityManager()->persist($expert);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove an expert from the database.
     */
    public function remove(Expert $expert, bool $flush = true): void
    {
        $this->getEntityManager()->remove($expert);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
