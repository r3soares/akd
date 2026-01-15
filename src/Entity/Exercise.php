<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $difficulty = null;

    /**
     * @var Collection<int, ExerciseSet>
     */
    #[ORM\OneToMany(targetEntity: ExerciseSet::class, mappedBy: 'exercise', orphanRemoval: true)]
    private Collection $exerciseSets;

    public function __construct()
    {
        $this->exerciseSets = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection<int, ExerciseSet>
     */
    public function getExerciseSets(): Collection
    {
        return $this->exerciseSets;
    }

    public function addExerciseSet(ExerciseSet $exerciseSet): static
    {
        if (!$this->exerciseSets->contains($exerciseSet)) {
            $this->exerciseSets->add($exerciseSet);
            $exerciseSet->setExercise($this);
        }

        return $this;
    }

    public function removeExerciseSet(ExerciseSet $exerciseSet): static
    {
        if ($this->exerciseSets->removeElement($exerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($exerciseSet->getExercise() === $this) {
                $exerciseSet->setExercise(null);
            }
        }

        return $this;
    }
}
