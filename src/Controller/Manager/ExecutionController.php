<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Exercise;
use App\Form\Manager\ExerciseType;
use App\Repository\ExerciseRepository;
use App\Routes\RouteName;
use App\Service\EntityServices\ExerciseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MANAGER')]
#[Route('/manager/execution')]
class ExecutionController extends AbstractController
{

}
