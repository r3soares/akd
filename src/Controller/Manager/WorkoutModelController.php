<?php

namespace App\Controller\Manager;

use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkoutModelController extends AbstractController
{
    #[Route('/manager/workout-models', name: 'manager_workout_models')]
    public function index(
        WorkoutRepository $workoutRepository,
        ExerciseRepository $exerciseRepository,
        ExerciseExecutionRepository $exerciseExecutionRepository): Response
    {
        $workouts = $workoutRepository->findBy([
            'trainee' => null
        ]);

        $exercises = $exerciseRepository->findAll();

        $exercicesExecutions = $exerciseExecutionRepository->findAll();

        return $this->render('manager/workout_models/index.html.twig', [
            'workouts' => $workouts,
            'exercises' => $exercises,
            'exerciseExecutions' => $exercicesExecutions
        ]);
    }

    #[Route('/manager/workout-models/add', name: 'manager_workout_models_add')]
    public function add()
    {

    }
}
