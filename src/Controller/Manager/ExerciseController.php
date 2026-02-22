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
#[Route('/manager/exercise')]
class ExerciseController extends AbstractController
{
    public function __construct(
        private ExerciseService $exerciseService
    ){}

    #[Route('', name: RouteName::MANAGER_EXERCISE_INDEX)]
    public function index(): Response
    {
        $exercises = $this->exerciseService->findAll();

        return $this->render('manager/exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/create', name: RouteName::MANAGER_EXERCISE_CREATE, methods: ['POST'])]
    public function create(Request $request): RedirectResponse
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->exerciseService->save($exercise);
            $this->addFlash('success', 'Exercício adicionado');
        }
        else if ($form->isSubmitted()) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE_INDEX);
    }


    #[Route('/edit/{id}', name: RouteName::MANAGER_EXERCISE_EDIT, methods: ['POST'])]
    public function edit(Exercise $exercise,Request $request): RedirectResponse {

        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->exerciseService->save($exercise);
            $this->addFlash('success', "{$exercise->getName()} atualizado com sucesso");
        } else if ($form->isSubmitted()) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('warning', $error->getMessage());
            }
        }

        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE_INDEX);
    }

    #[Route('/delete/{id}', name: RouteName::MANAGER_EXERCISE_DELETE, methods: ['POST'])]
    public function delete(Exercise $exercise): RedirectResponse {

        try {

            $this->exerciseService->delete($exercise);

            $this->addFlash('success', "{$exercise->getName()} excluído com sucesso");

        } catch (\Exception $e) {

            $this->addFlash('warning', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE_INDEX);
    }

    #[Route('/form/new', name: RouteName::MANAGER_EXERCISE_FORM_NEW)]
    public function formNew(): Response
    {
        $exercise = new Exercise();

        $form = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl(RouteName::MANAGER_EXERCISE_CREATE),
            'method' => 'POST',
        ]);

        return $this->render('manager/exercise/components/_exercise_modal.html.twig', [
            'exerciseForm' => $form->createView(),
            'isEdit' => false,
        ]);
    }

    #[Route('/form/edit/{id}', name: RouteName::MANAGER_EXERCISE_FORM_EDIT)]
    public function formEdit(Exercise $exercise): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl(RouteName::MANAGER_EXERCISE_EDIT, ['id' => $exercise->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('manager/exercise/components/_exercise_modal.html.twig', [
            'exerciseForm' => $form->createView(),
            'isEdit' => true,
        ]);
    }




}
