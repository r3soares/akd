<?php

namespace App\Controller\User;

use App\Routes\RouteName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/schedule')]
final class ScheduleController extends AbstractController
{
    #[Route('', name: RouteName::USER_SCHEDULE)]
    public function index(): Response
    {
        return $this->render('user/schedule/index.html.twig', [
            'controller_name' => 'ScheduleController',
        ]);
    }
}
