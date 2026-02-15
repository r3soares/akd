<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NavController extends AbstractController
{
    #[Route('/manager/nav', name: 'manager_nav')]
    public function index(): Response
    {
        return $this->render('nav/home.html.twig', [
            'routes' => [
                'Home' => 'manager_home',
            ],
        ]);
    }
}
