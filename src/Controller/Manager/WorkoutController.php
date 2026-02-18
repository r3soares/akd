<?php

namespace App\Controller\Manager;

use App\Entity\WorkoutExercise;
use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutExerciseRepository;
use App\Repository\WorkoutRepository;
use App\Routes\RouteName;
use App\Service\ExerciseExecutionService;
use App\Service\ExerciseService;
use App\Service\WorkoutExerciseService;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/workout')]
class WorkoutController extends AbstractController
{
    public function __construct(
        private WorkoutService         $workoutService,
        private WorkoutExerciseService $workoutExerciseService,
        private ExerciseService $exerciseService,
        private ExerciseExecutionService $exerciseExecutionService,
    ){}
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

    #[Route('/create', name: RouteName::MANAGER_WORKOUT_CREATE, methods: ['POST'])]
    public function create(
        Request $request
    ): RedirectResponse {

        try {
            $exercise = $this->exerciseService->get((int) $request->request->get('exercise'));
            $exerciseExecution = $this->exerciseExecutionService->get((int) $request->request->get('execution'));
            $workout = $this->workoutService->get((int) $request->request->get('workout'));

            $this->workoutExerciseService->create(
                $workout,
                $exercise,
                $exerciseExecution,
                (int)$request->request->get('position')
            );

            $this->addFlash('success', 'Exercício adicionado');

        } catch (\DomainException $e) {

            $this->addFlash('warning', $e->getMessage());

        } catch (\InvalidArgumentException $e) {

            $this->addFlash('danger', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT);
    }

    #[Route('/edit/{id}', name: RouteName::MANAGER_WORKOUT_EDIT, methods: ['POST'])]
    public function edit(WorkoutExercise $we, Request $request) : RedirectResponse
    {
        try {
            $exercise = $this->exerciseService->get((int) $request->request->get('exercise'));
            $exerciseExecution = $this->exerciseExecutionService->get((int) $request->request->get('execution'));

            $this->workoutExerciseService->update(
                $we,
                $we->getWorkout(),
                $exercise,
                $exerciseExecution,
                (int)$request->request->get('position')
            );

            $this->addFlash('success', "{$we->getWorkout()} atualizado com sucesso");

        } catch (\InvalidArgumentException | \DomainException $e) {

            $this->addFlash('warning', $e->getMessage());
        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT);
    }

}
