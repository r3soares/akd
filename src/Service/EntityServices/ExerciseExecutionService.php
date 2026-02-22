<?php

namespace App\Service\EntityServices;

use App\Entity\Exercise;
use App\Entity\Execution;
use App\Entity\ExerciseExecution;
use App\Repository\ExerciseExecutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExerciseExecutionService extends AbstractEntityService
{
    public function __construct(
        private ExerciseExecutionRepository $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        parent::__construct($entityManager, $validator);
    }

    protected function getRepository(): ExerciseExecutionRepository
    {
        return $this->repository;
    }

    /**
     * Cria uma nova relação ExerciseExecution
     */
    public function create(
        Exercise $exercise,
        Execution $execution
    ): ExerciseExecution {

        $exerciseExecution = new ExerciseExecution();
        $exerciseExecution->setExercise($exercise);
        $exerciseExecution->setExecution($execution);

        return $this->save($exerciseExecution);
    }

    /**
     * Atualiza uma relação existente
     */
    public function update(
        ExerciseExecution $exerciseExecution,
        Exercise $exercise,
        Execution $execution
    ): ExerciseExecution {

        $exerciseExecution->setExercise($exercise);
        $exerciseExecution->setExecution($execution);

        return $this->save($exerciseExecution);
    }


}
