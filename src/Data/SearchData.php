<?php

namespace App\Data;

use App\Entity\Categorie;
use App\Entity\Category;

class SearchData
{
    /**
     * @var string|null
     */
    public $query = '';

    public string $q = '';

    /**
     * @var Category[]
     */
    public array $categories = [];

    public ?int $max = null;

    public ?int $min = null;

    public string $NomProduit = '';

    public string $description = '';

    public ?int $quantite = null;
    
    public ?float $prix = null;

    public ?Categorie $categorie = null;
}
