<?php

namespace App\Service\EntityServices;

use App\Entity\ExerciseExecution;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Repository\WorkoutExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WorkoutExerciseService extends AbstractEntityService
{
    public function __construct(
        private WorkoutExerciseRepository $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        parent::__construct($entityManager, $validator);
    }

    protected function getRepository(): WorkoutExerciseRepository
    {
        return $this->repository;
    }

    public function create(
        Workout $workout,
        ExerciseExecution $exerciseExecution,
        ?int $position
    ): WorkoutExercise {

        $workoutExercise = new WorkoutExercise();
        $workoutExercise->setWorkout($workout);
        $workoutExercise->setExerciseExecution($exerciseExecution);
        $workoutExercise->setPosition($position);

        return $this->save($workoutExercise);
    }

    protected function beforeSave(object $workoutExercise): void
    {
        // impedir duplicação
        $existing = $this->repository->findOneBy([
            'workout' => $workoutExercise->getWorkout(),
            'exerciseExecution' => $workoutExercise->getExerciseExecution()
        ]);

        if ($existing && $existing->getId() !== $workoutExercise->getId()) {
            throw new \DomainException('Este exercício já existe no treino.');
        }

        // posição automática
        if (empty($workoutExercise->getPosition())) {

            $lastPosition = $this->repository->count([
                'workout' => $workoutExercise->getWorkout()
            ]);

            $workoutExercise->setPosition($lastPosition + 1);
        }
    }

    /**
     * UPDATE - mudar posição
     */
    public function changePosition(
        WorkoutExercise $workoutExercise,
        int $newPosition
    ): void {

        $workout = $workoutExercise->getWorkout();
        $oldPosition = $workoutExercise->getPosition();

        if ($newPosition === $oldPosition) {
            return;
        }

        // encontra quem está na nova posição
        $target = $this->repository->findOneBy([
            'workout' => $workout,
            'position' => $newPosition
        ]);

        if (!$target) {
            $workoutExercise->setPosition($newPosition);
        }

        else{
            $target->setPosition($oldPosition);
            $workoutExercise->setPosition($newPosition);
            $this->save($target);
        }

        $this->save($workoutExercise);
    }

}
