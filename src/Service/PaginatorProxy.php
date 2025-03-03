<?php


namespace App\Service;

use Knp\Component\Pager\PaginatorInterface;

class PaginatorProxy
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function paginate($query, int $page, int $limit)
    {
        return $this->paginator->paginate($query, $page, $limit);
    }
}
