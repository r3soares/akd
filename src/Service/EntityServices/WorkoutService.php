<?php

namespace App\Service\EntityServices;
use App\Entity\User;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class WorkoutService extends AbstractEntityService
{
    public function __construct(
        private WorkoutRepository $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        parent::__construct($entityManager, $validator);
    }

    protected function getRepository(): WorkoutRepository
    {
        return $this->repository;
    }

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

        $this->save($workout);

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

        return $this->save($workout);
    }
}
