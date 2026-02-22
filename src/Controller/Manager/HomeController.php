<?php

namespace App\Controller\Manager;

use App\Routes\RouteName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/')]
final class HomeController extends AbstractController
{
    #[Route('', name: RouteName::MANAGER_HOME)]
    public function index(): Response
    {
        return $this->render('manager/home/index.html.twig', [
            'routes' => [
                'Treinos' => ['route' => RouteName::MANAGER_WORKOUT_INDEX, 'desc' => 'Cadastre seus treinos'],
                'Exercícios' => ['route' => RouteName::MANAGER_EXERCISE_INDEX, 'desc' => 'Cadastre seus exercícios'],
            ],
        ]);
    }
}
