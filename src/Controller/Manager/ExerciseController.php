<?php

declare(strict_types=1);

namespace App\Controller\Manager;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExerciseController extends AbstractController
{
    #[Route('/manager/exercise', name: 'manager_exercise')]
    public function index(ExerciseRepository $exerciseRepository,): Response
    {
        $exercises = $exerciseRepository->findBy([], ['name' => 'ASC']);

        return $this->render('manager/exercise/index.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/manager/exercise/new', name: 'manager_exercise_new', methods: ['POST'])]
    public function new(
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
            return $this->redirectToRoute('manager_exercise');
        }

        $entityManager->persist($exercise);
        $entityManager->flush();

        $this->addFlash('success', "{$exercise->getName()} criado com sucesso");
        return $this->redirectToRoute('manager_exercise');
    }
}
