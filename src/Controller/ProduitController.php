<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Data\SearchData;
use App\Form\SearchForm;

#[Route('/produit')]
final class ProduitController extends AbstractController
{
    #[Route(name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository, Request $request): Response
    {   
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $produits = $produitRepository->findBySearch($data);
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'searchform' => $form->createView(),
        ]);
    }

    #[Route('/dbfrsproduit', name: 'dbfrsproduit', methods: ['GET'])]
    public function indexfrs(ProduitRepository $produitRepository): Response
    {
        return $this->render('dbFournisseurProduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository): Response
    {
        $produit = new Produit();
        $categories = $categorieRepository->findAll();
        $form = $this->createForm(ProduitType::class, $produit);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // /** @var UploadedFile $imageFile */
            // $imageFile = $form->get('image')->getData();

            // if ($imageFile) {
            //     $newFilename = uniqid().'.'.$imageFile->guessExtension();

            //     try {
            //         $imageFile->move(
            //             $this->getParameter('images_directory'),
            //             $newFilename
            //         );
            //     } catch (FileException $e) {
            //         // handle exception if something happens during file upload
            //     }

            //     $produit->setImage($newFilename);
            $uploadedFile = $form->get('image')->getData();
    
            if ($uploadedFile) {
                // Initialisation de Cloudinary
                $cloudinary = new \Cloudinary\Cloudinary($_ENV['CLOUDINARY_URL']);
    
                // Upload de l'image sur Cloudinary
                $uploadedResponse = $cloudinary->uploadApi()->upload($uploadedFile->getPathname(), [
                    'folder' => 'messages'
                ]);
    
                // Stocker l'URL de l'image dans l'entité Message
                $produit->setImage($uploadedResponse['secure_url']);
            }

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('dbfrsproduit', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
            'categories' => $categories,
        ]);
    }
    
    #[Route('/show/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(int $id, ProduitRepository $produitRepository): Response
    {
        $produit = $produitRepository->find($id);
        if (!$produit) {
            throw $this->createNotFoundException('Produit not found');
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        $produit = $produitRepository->find($id);
        if (!$produit) {
            throw $this->createNotFoundException('Produit not found');
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dbfrsproduit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dbfrsproduit', [], Response::HTTP_SEE_OTHER);
    }
}