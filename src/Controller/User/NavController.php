<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NavController extends AbstractController
{
    #[Route('/user/nav', name: 'user_nav')]
    public function index(): Response
    {
        return $this->render('nav/home.html.twig', [
            'routes' => [
                'Home' => 'user_home',
                'Perfil' => 'user_perfil',
                'Cronograma' => 'user_schedule',
                'Meus Treinos' => 'user_schedule',
            ],
        ]);
    }
}
