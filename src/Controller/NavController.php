<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NavController extends AbstractController
{
    #[Route('/nav', name: 'app_nav')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user) {
            return $this->home();
        }
        return $this->visitor();

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

    public function home(): Response
    {
        return $this->render('nav/home.html.twig', [
            'routes' => [
                'Home' => 'app_home',
                'Perfil' => 'app_perfil',
                'Cronograma' => 'app_schedule',
                'Meus Treinos' => 'app_workout',
            ],
        ]);
    }
}
