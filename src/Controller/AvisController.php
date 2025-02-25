<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/terrain/{id}/avis', name: 'ajouter_avis')]
    public function ajouterAvis(int $id, Request $request, TerrainRepository $terrainRepo, EntityManagerInterface $em): Response
    {
        $terrain = $terrainRepo->find($id);
        if (!$terrain) {
            throw $this->createNotFoundException("Terrain non trouvé");
        }

        // Vérifier que l'utilisateur a bien loué ce terrain
        $user = $this->getUser();
        $aLoue = false;
        foreach ($terrain->getLocations() as $location) {
            if ($location->getLocataire() === $user) {
                $aLoue = true;
                break;
            }
        }

        if (!$aLoue) {
            throw $this->createAccessDeniedException("Vous ne pouvez noter que les terrains que vous avez loués");
        }

        $avis = new Avis();
        $avis->setLocataire($user);
        $avis->setTerrain($terrain);

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', 'Votre avis a été enregistré !');
            return $this->redirectToRoute('terrain_detail', ['id' => $terrain->getId()]);
        }

        return $this->render('avis/ajouter.html.twig', [
            'form' => $form->createView(),
            'terrain' => $terrain
        ]);
    }
}
