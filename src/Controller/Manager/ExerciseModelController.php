<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseModelController extends AbstractController
{
    #[Route('/manager/exercise')]
    public function index(): Response
    {
        return $this->render('exercise/index.html.twig');
    }
}
