<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Placeholder($faker));
        // $product = new Product();
        // $manager->persist($product);

        // Create some categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $categorie = new Categorie();
            $categorie->setNomCategorie($faker->word());
            $categorie->setDescription($faker->paragraph());
            $manager->persist($categorie);
            $categories[] = $categorie;
        }

        for ($i = 0; $i < 10; $i++) {
            $product = new Produit();
            $product->setNomProduit($faker->words(3, true));         // e.g., "Awesome Product Name"
            $product->setDescription($faker->paragraph());       // a paragraph description
            $product->setPrix($faker->randomFloat(2, 10, 100));   // a price between 10 and 100
            $product->setQuantite($faker->numberBetween(1, 100));    // a random quantity between 1 and 100
            $product->setImage('https://picsum.photos/300/300?random=' . $faker->unique()->numberBetween(1, 10000));  // a random image URL          
            $product->setCategorie($faker->randomElement($categories)); // set a random category
            // If you have other fields (like createdAt, stock, etc.), you can set them similarly:
            // $product->setCreatedAt($faker->dateTimeThisYear());
            // $product->setStock($faker->numberBetween(1, 50));
            // $setImage =  // https://picsum.photos/640/480?random=24398
            // $setImage =  // https://picsum.photos/400/400?random=23446
                
            // Persist the product to the database
            $manager->persist($product);
        }

        $manager->flush();
    }
}
