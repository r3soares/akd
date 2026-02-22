<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128, unique: true)]
    #[Assert\NotBlank(message: 'O nome não pode ser vazio')]
    private ?string $name = null;

    /**
     * @var Collection<int, WorkoutExercise>
     */
    #[ORM\OneToMany(
        targetEntity: WorkoutExercise::class,
        mappedBy: 'workout',
        cascade: ['persist'],
        orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $workoutExercises;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'workouts')]
    private ?User $trainee = null;

    public function __construct()
    {
        $this->workoutExercises = new ArrayCollection();
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
        $this->name = mb_strtolower(trim($name));

        return $this;
    }

    /**
     * @return Collection<int, WorkoutExercise>
     */
    public function getWorkoutExercises(): Collection
    {
        return $this->workoutExercises;
    }

    public function addWorkoutExercise(WorkoutExercise $workoutExercise): static
    {
        if (!$this->workoutExercises->contains($workoutExercise)) {
            $this->workoutExercises->add($workoutExercise);
            $workoutExercise->setWorkout($this);
        }

        return $this;
    }

    public function removeWorkoutExercise(WorkoutExercise $workoutExercise): static
    {
        if ($this->workoutExercises->removeElement($workoutExercise)) {
            // set the owning side to null (unless already changed)
            if ($workoutExercise->getWorkout() === $this) {
                $workoutExercise->setWorkout(null);
            }
        }

        return $this;
    }

    public function addExerciseExecution(ExerciseExecution $exerciseExecution): void
    {
        $we = new WorkoutExercise();
        $we->setExerciseExecution($exerciseExecution);

        $this->addWorkoutExercise($we);
    }

    public function hasExerciseExecution(ExerciseExecution $exerciseExecution): bool
    {
        foreach ($this->workoutExercises as $we) {
            if ($we->getExerciseExecution() === $exerciseExecution) {
                return true;
            }
        }

        return false;
    }



    public function getTrainee(): ?User
    {
        return $this->trainee;
    }

    public function setTrainee(?User $trainee): static
    {
        $this->trainee = $trainee;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
