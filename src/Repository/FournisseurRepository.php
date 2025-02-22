<?php

namespace App\Repository;

use App\Entity\Fournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fournisseur>
 *
 * @method Fournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fournisseur[]    findAll()
 * @method Fournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fournisseur::class);
    }

    /**
     * Find a fournisseur by email.
     */
    public function findByEmail(string $email): ?Fournisseur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find all active fournisseurs.
     */
    public function findActiveFournisseurs(): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.actif = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find fournisseurs who are participating in an event.
     */
    public function findFournisseursByEvenement(int $eventId): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.evenements', 'e')
            ->andWhere('e.id = :eventId')
            ->setParameter('eventId', $eventId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find fournisseurs by product they supply.
     */
    public function findFournisseursByProduit(int $productId): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.produits', 'p')
            ->andWhere('p.id = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Save a fournisseur to the database.
     */
    public function save(Fournisseur $fournisseur, bool $flush = true): void
    {
        $this->getEntityManager()->persist($fournisseur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove a fournisseur from the database.
     */
    public function remove(Fournisseur $fournisseur, bool $flush = true): void
    {
        $this->getEntityManager()->remove($fournisseur);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
