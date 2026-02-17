<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use App\Routes\RouteName;
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
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): RedirectResponse
    {
        $exercise = new Exercise();

        $exercise->setName($request->request->get('name'));
        $exercise->setDescription($request->request->get('description'));

        $errors = $validator->validate($exercise);
        if(count($errors) > 0){
            $this->addFlash('warning',$errors[0]->getMessage());
            return $this->redirectToRoute(RouteName::MANAGER_EXERCISE);
        }

        $entityManager->persist($exercise);
        $entityManager->flush();

        $this->addFlash('success', "{$exercise->getName()} criado com sucesso");
        return $this->redirectToRoute(RouteName::MANAGER_EXERCISE);
    }
}
