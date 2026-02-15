<?php

namespace App\Controller\Admin\Models;

use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkoutModelController extends AbstractController
{

    #[Route('/admin/workout-models', name: 'admin_workout_models')]
    public function index(
        WorkoutRepository $workoutRepository,
        ExerciseRepository $exerciseRepository,
        ExerciseExecutionRepository $exerciseExecutionRepository,
        AdminContext $context): Response
    {
        $workouts = $workoutRepository->findBy([
            'trainee' => null
        ]);

        $exercises = $exerciseRepository->findAll();

        $exercicesExecutions = $exerciseExecutionRepository->findAll();

        return $this->render('admin/workout_models/index.html.twig', [
            'workouts' => $workouts,
            'exercises' => $exercises,
            'exerciseExecutions' => $exercicesExecutions,
            'ea' => $context
        ]);
    }
}
