<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtlisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find users by role.
     * Example usage: $repository->findByRole('ROLE_ADMIN');
     */
    public function findByRole(string $role): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%' . $role . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all active users.
     */
    public function findActiveUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.actif = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Save a user to the database.
     */
    public function save(Utilisateur $utilisateur, bool $flush = true): void
    {
        $this->getEntityManager()->persist($utilisateur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove a user from the database.
     */
    public function remove(Utilisateur $utilisateur, bool $flush = true): void
    {
        $this->getEntityManager()->remove($utilisateur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
