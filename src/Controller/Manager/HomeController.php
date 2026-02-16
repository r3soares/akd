<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/manager/', name: 'manager_home')]
    public function index(): Response
    {
        return $this->render('manager/home/index.html.twig', [
            'routes' => [
                'Treinos' => ['route' => 'manager_workout', 'desc' => 'Cadastre seus treinos'],
            ],
        ]);
    }
}
