<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/profile/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'routes' => [
                'Perfil' => ['route' => 'app_perfil', 'desc' => 'Seus dados informados, como nome, peso, altura e contatos'],
                'Meus Treinos' => ['route' => 'app_workout', 'desc' => 'Visualize seus grupos de treinos cadastrados'],
                'Cronograma' => ['route' => 'app_schedule', 'desc' => 'Como seus treinos estão distribuídos na semana'],
            ],
        ]);
    }
}
