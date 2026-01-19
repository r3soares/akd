<?php

namespace App\Entity;

use App\Repository\ExerciseSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseSetRepository::class)]
class ExerciseSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseSets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercise $exercise = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseSets')]
    private ?SetRep $setRep = null;

    /**
     * @var Collection<int, WorkoutExerciseSet>
     */
    #[ORM\OneToMany(targetEntity: WorkoutExerciseSet::class, mappedBy: 'exerciseSet')]
    private Collection $workoutExerciseSets;

    public function __construct()
    {
        $this->workoutExerciseSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSetRep(): ?SetRep
    {
        return $this->setRep;
    }

    public function setSetRep(?SetRep $setRep): static
    {
        $this->setRep = $setRep;

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
            $workoutExerciseSet->setExerciseSet($this);
        }

        return $this;
    }

    public function removeWorkoutExerciseSet(WorkoutExerciseSet $workoutExerciseSet): static
    {
        if ($this->workoutExerciseSets->removeElement($workoutExerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($workoutExerciseSet->getExerciseSet() === $this) {
                $workoutExerciseSet->setExerciseSet(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->exercise->getName() . ' - ' . $this->setRep->__toString();
    }
}
