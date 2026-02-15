<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/user/', name: 'user_home')]
    public function index(): Response
    {
        return $this->render('user/home/index.html.twig', [
            'routes' => [
                'Perfil' => ['route' => 'user_perfil', 'desc' => 'Seus dados informados, como nome, peso, altura e contatos'],
                'Meus Treinos' => ['route' => 'user_schedule', 'desc' => 'Visualize seus grupos de treinos cadastrados'],
                'Cronograma' => ['route' => 'user_schedule', 'desc' => 'Como seus treinos estão distribuídos na semana'],
            ],
        ]);
    }
}
