<?php

namespace App\Controller\Admin;

use App\Entity\Animals;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/animals', name: 'admin_animals_')]
class AnimalsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/animals/index.html.twig', []);
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/animals/index.html.twig', []);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Animals $animal): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le voter
        $this->denyAccessUnlessGranted('ANIMAL_EDIT', $animal);
        return $this->render('admin/animals/index.html.twig', []);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Animals $animal): Response
    {
        
        // On vérifie si l'utilisateur peut supprimer avec le voter
        $this->denyAccessUnlessGranted('ANIMAL_DELETE', $animal);
        return $this->render('admin/animals/index.html.twig', []);
    }
}
