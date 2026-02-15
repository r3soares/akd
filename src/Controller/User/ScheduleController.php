<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScheduleController extends AbstractController
{
    #[Route('/user/schedule', name: 'user_schedule')]
    public function index(): Response
    {
        return $this->render('user/schedule/index.html.twig', [
            'controller_name' => 'ScheduleController',
        ]);
    }
}
