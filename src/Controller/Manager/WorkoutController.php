<?php

namespace App\Controller\Manager;

use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutExerciseRepository;
use App\Repository\WorkoutRepository;
use App\Routes\RouteName;
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
        Request $request,
        WorkoutService $workoutService
    ): RedirectResponse {

        try {

            $workoutService->addExercise(
                (int) $request->request->get('workout'),
                (int) $request->request->get('exercise'),
                (int) $request->request->get('execution')
            );

            $this->addFlash('success', 'Exercício adicionado');

        } catch (\DomainException $e) {

            $this->addFlash('warning', $e->getMessage());

        } catch (\InvalidArgumentException $e) {

            $this->addFlash('danger', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT);
    }

}
