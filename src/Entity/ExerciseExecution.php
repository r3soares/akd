<?php

namespace App\Entity;

use App\Repository\ExerciseExecutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseExecutionRepository::class)]
#[ORM\Table(
    name: 'exercise_execution',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'exercise_execution_unique',
            columns: ['exercise_id', 'execution_id']
        )
    ]
)]
class ExerciseExecution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, WorkoutExercise>
     */
    #[ORM\OneToMany(
        targetEntity: WorkoutExercise::class,
        mappedBy: 'exerciseExecution',
        cascade: ['persist'],
        orphanRemoval: true
    )]
    private Collection $workoutExercises;

    #[ORM\ManyToOne(inversedBy: 'exerciseExecutions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercise $exercise = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseExecutions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Execution $execution = null;

    public function __construct()
    {
        $this->workoutExercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $workoutExercise->setExerciseExecution($this);
        }

        return $this;
    }

    public function removeWorkoutExercise(WorkoutExercise $workoutExercise): static
    {
        if ($this->workoutExercises->removeElement($workoutExercise)) {
            // set the owning side to null (unless already changed)
            if ($workoutExercise->getExerciseExecution() === $this) {
                $workoutExercise->setExerciseExecution(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->exercise . ' - ' . $this->execution;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): static
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getExecution(): ?Execution
    {
        return $this->execution;
    }

    public function setExecution(?Execution $execution): static
    {
        $this->execution = $execution;

        return $this;
    }
}
