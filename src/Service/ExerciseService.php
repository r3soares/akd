<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExerciseService
{
    public function __construct(
        private ExerciseRepository $exerciseRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {}

    public function get(int $id): Exercise
    {
        $exercise = $this->exerciseRepository->find($id);
        if (!$exercise) {
            throw new \DomainException('Exercício não encontrado.');
        }
        return $exercise;
    }

    public function save(Exercise $exercise)
    {
        $this->entityManager->persist($exercise);
        $this->entityManager->flush();
    }

    public function create(?string $name, ?string $description): Exercise
    {
        $exercise = new Exercise();

        $this->applyData($exercise, $name, $description);

        $this->entityManager->persist($exercise);
        $this->entityManager->flush();

        return $exercise;
    }

    public function update(Exercise $exercise, ?string $name, ?string $description): Exercise
    {
        $this->applyData($exercise, $name, $description);

        $this->entityManager->flush();

        return $exercise;
    }

    public function delete(int $id): void
    {
        $exercise = $this->get($id);

        if($exercise->getWorkoutExercises()){
            throw new \DomainException('Este exercício está vinculado a um ou mais treinos');
        }

        $this->entityManager->remove($exercise);
        $this->entityManager->flush();
    }

    private function applyData(Exercise $exercise, ?string $name, ?string $description): void
    {
        $exercise->setName($name);
        $exercise->setDescription($description);

        $errors = $this->validator->validate($exercise);

        if (count($errors) > 0) {
            throw new \DomainException($errors[0]->getMessage());
        }
    }
}
