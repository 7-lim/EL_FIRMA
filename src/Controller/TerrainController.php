<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agriculteur;

class TerrainController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Créer un nouveau terrain
    #[Route('/terrain/new', name: 'terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $terrain = new Terrain();

        // Vérifie si l'utilisateur connecté est un Agriculteur
        $user = $this->getUser();
        if ($user instanceof Agriculteur) {
            $terrain->setAgriculteur($user);
        } else {
            // Si l'utilisateur n'est pas un Agriculteur, redirigez-le ou affichez une erreur
            $this->addFlash('error', 'Seuls les agriculteurs peuvent ajouter des terrains.');
            return $this->redirectToRoute('login'); //dirigez vers une page appropriée
        }

        // Crée le formulaire
        $form = $this->createForm(TerrainType::class, $terrain);

        // Traite la requête et sauvegarde les données
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($terrain);
            $this->entityManager->flush();

            // Message de succès et redirection
            $this->addFlash('success', 'Votre terrain a été ajouté avec succès !');
            return $this->redirectToRoute('terrain_list');
        }

        // Affiche le formulaire dans la vue
        return $this->render('terrain/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Afficher la liste des terrains
    #[Route('/terrains', name: 'terrain_list', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $terrains = $terrainRepository->findAll();

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    // Afficher le détail d'un terrain
    #[Route('/terrain/{id}', name: 'terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    // Modifier un terrain existant
    #[Route('/terrain/{id}/edit', name: 'terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Terrain modifié avec succès.');

            return $this->redirectToRoute('terrain_list');
        }

        return $this->render('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form'    => $form->createView(),
        ]);
    }

    // Supprimer un terrain
    #[Route('/terrain/{id}', name: 'terrain_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terrain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->entityManager;
            $entityManager->remove($terrain);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Terrain supprimé avec succès.');

        return $this->redirectToRoute('terrain_list');
    }
}