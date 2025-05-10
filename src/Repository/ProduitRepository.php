<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
        $this->paginator = $paginator;

    }

    public function findBySearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.categorie', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.NomProduit LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('p.Prix >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.Prix <= :max')
                ->setParameter('max', $search->max);
        }

         $query= $query->getQuery();

         return $this-> paginator->paginate(
            $query,
            $search->page,
            3
         );
    }

//     public function save(Produit $produit): void
//     {
//         $this->_em->persist($produit);
//         $this->_em->flush();
//     }
//     public function findByCategorieWithFilters($categorieId, $price = null, $name = null)
// {
//     $qb = $this->createQueryBuilder('p')
//         ->where('p.categorie = :categorie')
//         ->setParameter('categorie', $categorieId);

//     if ($price) {
//         $qb->andWhere('p.price <= :price')
//            ->setParameter('price', $price);
//     }

//     if ($name) {
//         $qb->andWhere('p.NomProduit LIKE :name')
//            ->setParameter('name', "%$name%");
//     }

//     return $qb->getQuery()->getResult();
// }


    //    /**
    //     * @return Produit[] Returns an array of Produit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}