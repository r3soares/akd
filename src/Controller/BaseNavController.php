<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BaseNavController extends AbstractController
{
    #[Route('/nav', name: 'app_nav')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->visitor();
        }

        $routes = [];

        if ($this->isGranted('ROLE_USER')) {
            $routes = array_merge($routes,[
                'Home' => 'user_home',
                'Perfil' => 'user_perfil',
                'Cronograma' => 'user_schedule',
                'Meus Treinos' => 'user_schedule'
            ]);
        }

        if ($this->isGranted('ROLE_MANAGER')) {
            $routes = array_merge($routes,[
                'Manager Profile' => 'manager_home',
            ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            $routes = array_merge($routes,[
                'Admin Profile' => 'admin',
            ]);
        }

        if(empty($routes)){
            throw $this->createAccessDeniedException('Usuário inválido');
        }

        return $this->render('nav/home.html.twig', [
            'routes' => $routes,
        ]);
    }

    public function visitor(): Response
    {
        return $this->render('nav/visitor.html.twig', [
            'routes' => [
                'Home' => 'app_visitor',
                'About' => 'app_visitor',
            ],
        ]);
    }
}
