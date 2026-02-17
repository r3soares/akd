<?php

namespace App\Controller\Manager;

use App\Entity\WorkoutExercise;
use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutExerciseRepository;
use App\Repository\WorkoutRepository;
use App\Routes\RouteName;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/workout')]
class WorkoutController extends AbstractController
{
    #[Route('', RouteName::MANAGER_WORKOUT)]
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

        return $this->render('manager/workout/index.html.twig', [
            'workouts' => $workouts,
            'exercises' => $exercises,
            'exerciseExecutions' => $exercicesExecutions
        ]);
    }

    #[Route('/create', name: RouteName::MANAGER_WORKOUT_CREATE, methods: ['POST']) ]
    public function create(
        Request $request,
        WorkoutRepository $workoutRepository,
        WorkoutExerciseRepository  $workoutExerciseRepository,
        ExerciseRepository $exerciseRepository,
        ExerciseExecutionRepository $exerciseExecutionRepository,
        EntityManagerInterface $entityManager
    ) : RedirectResponse
    {
        $workoutId = $request->request->get('workout');
        $exerciseId = $request->request->get('exercise');
        $executionId = $request->request->get('execution');

        // Buscar entidades
        $workout = $workoutRepository->find($workoutId);
        $exercise = $exerciseRepository->find($exerciseId);
        $execution = $exerciseExecutionRepository->find($executionId);

        if (!$workout || !$exercise || !$execution) {
            throw $this->createNotFoundException('Treino, Exercício ou Execução inválidos');
        }

        $workoutExercise = $workoutExerciseRepository->findBy([
            'exercise' => $exercise,
            'exerciseExecution' => $execution
        ]);

        if($workoutExercise){
            $duplicated = $workout->getWorkoutExercises()->contains($workoutExercise);

            if($duplicated){
                $this->addFlash('warning', 'Este exercício já existe neste treino');
                return $this->redirectToRoute(RouteName::MANAGER_WORKOUT);
            }
        }

        else{
            $we = new WorkoutExercise();
            $we->setExercise($exercise);
            $we->setWorkout($workout);
            $we->setExerciseExecution($execution);
            $workoutExercise = $we;
        }
        // Aqui você adiciona o exercício ao workout
        $workout->addWorkoutExercise($workoutExercise);

        $entityManager->persist($workout);
        $entityManager->flush();

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT); // ou qualquer página de volta
    }
}
