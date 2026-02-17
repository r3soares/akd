<?php

namespace App\Service;

use App\Repository\WorkoutRepository;
use App\Repository\ExerciseRepository;
use App\Repository\ExerciseExecutionRepository;
use Doctrine\ORM\EntityManagerInterface;

class WorkoutService
{
    public function __construct(
        private WorkoutRepository $workoutRepository,
        private ExerciseRepository $exerciseRepository,
        private ExerciseExecutionRepository $executionRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function addExercise(
        int $workoutId,
        int $exerciseId,
        int $executionId
    ): void {

        $workout = $this->workoutRepository->find($workoutId);
        $exercise = $this->exerciseRepository->find($exerciseId);
        $execution = $this->executionRepository->find($executionId);

        if (!$workout || !$exercise || !$execution) {
            throw new \InvalidArgumentException('Dados inválidos');
        }

        if ($workout->hasExercise($exercise, $execution)) {
            throw new \DomainException('Este exercício já existe neste treino');
        }

        $workout->addExercise($exercise, $execution);

        $this->entityManager->flush();
    }
}
