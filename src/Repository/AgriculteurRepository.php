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
     * Find an agriculteur by email.
     */
    public function findByEmail(string $email): ?Agriculteur
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all active agriculteurs.
     */
    public function findActiveAgriculteurs(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.actif = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find agriculteurs by location.
     */
    public function findByLocalisation(string $localisation): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.localisation = :localisation')
            ->setParameter('localisation', $localisation)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find agriculteurs participating in an event.
     */
    public function findAgriculteursByEvenement(int $evenementId): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.evenements', 'e')
            ->andWhere('e.id = :evenementId')
            ->setParameter('evenementId', $evenementId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Save an agriculteur to the database.
     */
    public function save(Agriculteur $agriculteur, bool $flush = true): void
    {
        $this->getEntityManager()->persist($agriculteur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove an agriculteur from the database.
     */
    public function remove(Agriculteur $agriculteur, bool $flush = true): void
    {
        $this->getEntityManager()->remove($agriculteur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
