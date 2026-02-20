<?php

namespace App\Service\EntityServices;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @extends AbstractEntityService<Exercise>
 */
class ExerciseService extends AbstractEntityService
{
    public function __construct(
        private ExerciseRepository $exerciseRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {}

    protected function getRepository(): ExerciseRepository
    {
        return $this->repository;
    }

    public function create(string $name): Exercise
    {
        $name = trim($name);

        $exercise = new Exercise();
        $exercise->setName($name);

        return $this->save($exercise);
    }

    public function update(Exercise $exercise, string $name): Exercise
    {
        $name = trim($name);

        $exercise->setName($name);

        return $this->save($exercise);
    }
}
