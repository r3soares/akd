<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Repository\ExerciseExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutExerciseRepository;
use App\Repository\WorkoutRepository;
use App\Service\WorkoutService;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\equalTo;

class WorkoutExerciseService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface     $validator, private readonly WorkoutService $workoutService,
    ) {}

    public function save(WorkoutExercise $we)
    {
        $wes = $we->getWorkout()->getWorkoutExercises();
        $finalPos = max(0, $we->getPosition()) ?: $this->workoutService->getLastPosition($wes)+1    ;
        $we->setPosition($finalPos);
        $this->entityManager->persist($we);
        $this->entityManager->flush();
    }

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
        //Organiza a ordem dos exercícios
        $position = max(0, $position) ?: $this->workoutService->getLastPosition($workout->getWorkoutExercises()) + 1;
        $workoutExercise->setPosition($position);

        $errors = $this->validator->validate($workoutExercise);

        if (count($errors) > 0) {
            throw new \DomainException($errors[0]->getMessage());
        }
    }

}
