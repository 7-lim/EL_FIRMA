<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    /**
     * Find reclamations by user (Agriculteur).
     */
    public function findByAgriculteur(int $agriculteurId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.agriculteur = :agriculteurId')
            ->setParameter('agriculteurId', $agriculteurId)
            ->orderBy('r.dateSoumission', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find reclamations assigned to an administrator.
     */
    public function findByAdministrateur(int $adminId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.administrateur = :adminId')
            ->setParameter('adminId', $adminId)
            ->orderBy('r.dateTraitement', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all unresolved reclamations.
     */
    public function findUnresolved(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.statut != :resolved')
            ->setParameter('resolved', 'résolu')
            ->orderBy('r.dateSoumission', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find recent reclamations (submitted in the last X days).
     */
    public function findRecent(int $days = 7): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.dateSoumission >= :dateLimit')
            ->setParameter('dateLimit', new \DateTime("-$days days"))
            ->orderBy('r.dateSoumission', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Save a reclamation to the database.
     */
    public function save(Reclamation $reclamation, bool $flush = true): void
    {
        $this->getEntityManager()->persist($reclamation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove a reclamation from the database.
     */
    public function remove(Reclamation $reclamation, bool $flush = true): void
    {
        $this->getEntityManager()->remove($reclamation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
