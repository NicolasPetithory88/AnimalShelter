<?php

namespace App\Controller;

use App\Entity\Races;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/races', name: 'races_')]
class RacesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function list(Races $race): Response
    {
        //On va chercher la liste des animaux de la race
        $animals = $race->getAnimals();

        return $this->render('races/list.html.twig', [
            'race' => $race,
            'animals' => $animals,
        ]);
       
    }
}
