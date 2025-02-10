<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {   
        $products = [
            ['name' => 'Green Tea', 'description' => 'Healthy and fresh.', 'image' => 'img/product-1.jpg'],
            ['name' => 'Black Tea', 'description' => 'Rich in flavor.', 'image' => 'img/product-2.jpg'],
            ['name' => 'Spiced Tea', 'description' => 'Full of aroma.', 'image' => 'img/product-3.jpg'],
            ['name' => 'Organic Tea', 'description' => 'Pure and natural.', 'image' => 'img/product-4.jpg'],
        ];
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}

