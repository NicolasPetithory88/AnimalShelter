<?php

namespace App\Controller;

use App\Entity\Races;
use App\Repository\AnimalsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/races', name: 'races_')]
class RacesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function list(Races $race, AnimalsRepository $animalsRepository, Request $request): Response
    {
        // On va chercher le numéro de page dans l'url
        $page = $request->query->getInt('page', 1);

        //On va chercher la liste des animaux de la race
        $animals = $animalsRepository->findAnimalsPaginated($page, $race->getSlug(), 1);

        return $this->render('races/list.html.twig', [
            'race' => $race,
            'animals' => $animals,
        ]);
       
    }
}
