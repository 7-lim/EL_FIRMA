<?php

namespace App\Service;



use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Pagerfanta\Pagerfanta;

class TerrainSearchService
{
    private PaginatedFinderInterface $finder;

    public function __construct(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    public function search(string $query, int $page = 1, int $limit = 10): Pagerfanta
    {
        return $this->finder->findPaginated($query)
            ->setMaxPerPage($limit)
            ->setCurrentPage($page);
    }
}