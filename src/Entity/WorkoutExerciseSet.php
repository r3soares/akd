<?php

namespace App\Entity;

use App\Repository\WorkoutExerciseSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutExerciseSetRepository::class)]
class WorkoutExerciseSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'workoutExerciseSets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExerciseSet $exerciseSet = null;

    #[ORM\ManyToOne(inversedBy: 'workoutExerciseSets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExerciseSet(): ?ExerciseSet
    {
        return $this->exerciseSet;
    }

    public function setExerciseSet(?ExerciseSet $exerciseSet): static
    {
        $this->exerciseSet = $exerciseSet;

        return $this;
    }

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): static
    {
        $this->workout = $workout;

        return $this;
    }
}
