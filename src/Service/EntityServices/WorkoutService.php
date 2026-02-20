<?php

namespace App\Service\EntityServices;
use App\Entity\User;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class WorkoutService
{
    public function __construct(
        private WorkoutRepository $repository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {}

    /**
     * Cria um novo Workout
     */
    public function create(
        string $name,
        ?User $trainee = null
    ): Workout {

        $workout = new Workout();
        $workout->setName(trim($name));
        $workout->setTrainee($trainee);

        $this->validate($workout);

        $this->entityManager->persist($workout);
        $this->entityManager->flush();

        return $workout;
    }

    /**
     * Persiste (create ou update)
     */
    public function save(Workout $workout): Workout
    {
        $this->validate($workout);

        $this->entityManager->persist($workout);
        $this->entityManager->flush();

        return $workout;
    }

    /**
     * Atualiza
     */
    public function update(
        Workout $workout,
        string $name,
        ?User $trainee = null
    ): Workout {

        $workout->setName(trim($name));
        $workout->setTrainee($trainee);

        $this->validate($workout);

        $this->entityManager->flush();

        return $workout;
    }

    /**
     * Busca por ID
     */
    public function find(int $id): ?Workout
    {
        return $this->repository->find($id);
    }

    /**
     * Busca ou falha
     */
    public function findOrFail(int $id): Workout
    {
        $workout = $this->repository->find($id);

        if (!$workout) {
            throw new \RuntimeException('Workout não encontrado.');
        }

        return $workout;
    }

    /**
     * Lista todos
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Remove
     */
    public function delete(Workout $workout): void
    {
        $this->entityManager->remove($workout);
        $this->entityManager->flush();
    }

    /**
     * Validação centralizada
     */
    private function validate(Workout $workout): void
    {
        $errors = $this->validator->validate($workout);

        if (count($errors) > 0) {
            throw new ValidationFailedException($workout, $errors);
        }
    }
}
