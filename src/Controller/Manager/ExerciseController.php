<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use App\Routes\RouteName;
use App\Service\ExerciseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Loader\Configurator\Routes;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/manager/exercise')]
class ExerciseController extends AbstractController
{
    public function __construct(
        private ExerciseService $exerciseService
    ){}

    #[Route('', name: RouteName::MANAGER_EXERCISE)]
    public function index(ExerciseRepository $exerciseRepository,): Response
    {
        $exercises = $exerciseRepository->findBy([], ['name' => 'ASC']);

        return $this->render('manager/exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/create', name: RouteName::MANAGER_EXERCISE_CREATE, methods: ['POST'])]
    public function create(
        Request $request
    ): RedirectResponse
    {
        try {

            $exercise = $this->exerciseService->create(
                $request->request->get('name'),
                $request->request->get('description')
            );

            $this->addFlash('success', "{$exercise->getName()} criado com sucesso");

        } catch (\InvalidArgumentException $e) {

            $this->addFlash('warning', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE);
    }

    #[Route('/edit/{id}', name: RouteName::MANAGER_EXERCISE_EDIT, methods: ['POST'])]
    public function edit(
        Exercise $exercise,
        Request $request
    ): RedirectResponse {

        try {
            $exercise = $this->exerciseService->update(
                $exercise,
                $request->request->get('name'),
                $request->request->get('description')
            );

            $this->addFlash('success', "{$exercise->getName()} atualizado com sucesso");

        } catch (\InvalidArgumentException | \DomainException $e) {

            $this->addFlash('warning', $e->getMessage());

        }

        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE);
    }



}
