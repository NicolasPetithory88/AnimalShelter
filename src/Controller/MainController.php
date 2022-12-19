<?php

namespace App\Controller;

use App\Repository\RacesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(RacesRepository $racesrepository): Response
    {
        return $this->render('main/index.html.twig',[
            'races' => $racesrepository->findBy([], ['racesOrder' => 'asc'])
        ]);
    }
}
