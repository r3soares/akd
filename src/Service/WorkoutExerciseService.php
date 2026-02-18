<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WorkoutExerciseService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {}

    public function create(
        Workout $workout,
        Exercise $exercise,
        ExerciseExecution $exerciseExecution,
        int $position): WorkoutExercise
    {
        $workoutExercise = new WorkoutExercise();

        $this->applyData($workoutExercise, $workout, $exercise, $exerciseExecution, $position);

        $this->entityManager->persist($workoutExercise);
        $this->entityManager->flush();

        return $workoutExercise;
    }

    public function update(
        WorkoutExercise $workoutExercise,
        Workout $workout,
        Exercise $exercise,
        ExerciseExecution $exerciseExecution,
        int $position): WorkoutExercise
    {
        $this->applyData($workoutExercise, $workout, $exercise, $exerciseExecution, $position);

        $this->entityManager->flush();

        return $workoutExercise;
    }

    private function applyData(
        WorkoutExercise $workoutExercise,
        Workout $workout,
        Exercise $exercise,
        ExerciseExecution $exerciseExecution,
        int $position): void
    {
        $workoutExercise->setWorkout($workout);
        $workoutExercise->setExercise($exercise);
        $workoutExercise->setExerciseExecution($exerciseExecution);
        $position = max(0, $position) ?: count($workout->getWorkoutExercises());
        $workoutExercise->setPosition($position);

        $errors = $this->validator->validate($workoutExercise);

        if (count($errors) > 0) {
            throw new \DomainException($errors[0]->getMessage());
        }
    }

}
