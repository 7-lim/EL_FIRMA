<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * Find a category by its name.
     *
     * @param string $nomCategorie
     * @return Categorie|null
     */
    public function findByName(string $nomCategorie): ?Categorie
    {
        return $this->findOneBy(['nomCategorie' => $nomCategorie]);
    }

    /**
     * Find all categories ordered by name.
     *
     * @return Categorie[]
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.nomCategorie', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find categories containing a specific keyword in their description.
     *
     * @param string $keyword
     * @return Categorie[]
     */
    public function findByDescriptionContaining(string $keyword): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.description LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('c.nomCategorie', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Add more custom query methods here as needed
}