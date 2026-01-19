<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    /**
     * @var Collection<int, WorkoutExerciseSet>
     */
    #[ORM\OneToMany(targetEntity: WorkoutExerciseSet::class, mappedBy: 'workout', orphanRemoval: true)]
    private Collection $workoutExerciseSets;

    public function __construct()
    {
        $this->workoutExerciseSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutExerciseSet>
     */
    public function getWorkoutExerciseSets(): Collection
    {
        return $this->workoutExerciseSets;
    }

    public function addWorkoutExerciseSet(WorkoutExerciseSet $workoutExerciseSet): static
    {
        if (!$this->workoutExerciseSets->contains($workoutExerciseSet)) {
            $this->workoutExerciseSets->add($workoutExerciseSet);
            $workoutExerciseSet->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutExerciseSet(WorkoutExerciseSet $workoutExerciseSet): static
    {
        if ($this->workoutExerciseSets->removeElement($workoutExerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($workoutExerciseSet->getWorkout() === $this) {
                $workoutExerciseSet->setWorkout(null);
            }
        }

        return $this;
    }
}
