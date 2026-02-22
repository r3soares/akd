<?php

namespace App\Controller\Manager;

use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Form\Manager\WorkoutExerciseType;
use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use App\Routes\RouteName;
use App\Service\EntityServices\ExecutionService;
use App\Service\EntityServices\ExerciseExecutionService;
use App\Service\EntityServices\ExerciseService;
use App\Service\EntityServices\WorkoutExerciseService;
use App\Service\EntityServices\WorkoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_MANAGER')]
#[Route('/manager/workout')]
class WorkoutController extends AbstractController
{
    public function __construct(
        private WorkoutService  $wService,
        private WorkoutExerciseService   $weService,
    ){}
    #[Route('', RouteName::MANAGER_WORKOUT_INDEX)]
    public function index(): Response
    {
        $workouts = $this->wService->findAll();

        return $this->render('manager/workout/index.html.twig', [
            'workouts' => $workouts
        ]);
    }

    #[Route('/create', name: RouteName::MANAGER_WORKOUT_CREATE, methods: ['POST'])]
    public function create(
        Request $request
    ): RedirectResponse {

        $we = new WorkoutExercise();
        $form = $this->createForm(WorkoutExerciseType::class, $we);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->weService->save($we);
            $this->addFlash('success', 'Exercício adicionado');
        }
        else if ($form->isSubmitted()) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT_INDEX);
    }

    #[Route('/edit/{id}', name: RouteName::MANAGER_WORKOUT_EDIT, methods: ['POST'])]
    public function edit(WorkoutExercise $we, Request $request) : RedirectResponse
    {
        $form = $this->createForm(WorkoutExerciseType::class, $we);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->weService->save($we);
            $this->addFlash('success', "{$we->getWorkout()} atualizado com sucesso");
        } else if ($form->isSubmitted()) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT_INDEX);
    }

    #[Route('/delete/{id}', name: RouteName::MANAGER_WORKOUT_DELETE, methods: ['POST'])]
    public function delete(
        WorkoutExercise $workoutExercise
    ): RedirectResponse {

        try {

            $this->weService->delete($workoutExercise);

            $this->addFlash('success', "{$workoutExercise->getExerciseExecution()->getExercise()} excluído com sucesso");

        } catch (\Exception $e) {

            $this->addFlash('warning', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_WORKOUT_INDEX);
    }

    #[Route('/form/new/{id}', name: RouteName::MANAGER_WORKOUT_FORM_NEW)]
    public function formNew(Workout $workout, WorkoutRepository $workoutRepository): Response
    {
        $workoutExercise = new WorkoutExercise();
        $workoutExercise->setWorkout($workout); // associa o Workout

        $form = $this->createForm(WorkoutExerciseType::class, $workoutExercise, [
            'action' => $this->generateUrl(RouteName::MANAGER_WORKOUT_CREATE),
            'method' => 'POST',
        ]);

        return $this->render('manager/workout/components/_exercise_modal.html.twig', [
            'exerciseForm' => $form->createView(),
            'isEdit' => false,
        ]);
    }

    #[Route('/form/edit/{id}', name: RouteName::MANAGER_WORKOUT_FORM_EDIT)]
    public function formEdit(WorkoutExercise $we, WorkoutRepository $workoutRepository): Response
    {
        $form = $this->createForm(WorkoutExerciseType::class, $we, [
            'action' => $this->generateUrl(RouteName::MANAGER_WORKOUT_EDIT, ['id' => $we->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('manager/workout/components/_exercise_modal.html.twig', [
            'exerciseForm' => $form->createView(),
            'isEdit' => true,
        ]);
    }

}
