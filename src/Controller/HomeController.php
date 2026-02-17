<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routes\RouteName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: RouteName::APP_HOME)]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
