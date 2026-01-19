<?php

namespace App\Entity;

use App\Repository\SetRepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetRepRepository::class)]
class SetRep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?int $repetition = null;
    #[ORM\Column]
    private ?int $sets = null;

    /**
     * @var Collection<int, ExerciseSet>
     */
    #[ORM\OneToMany(targetEntity: ExerciseSet::class, mappedBy: 'setRep')]
    private Collection $exerciseSets;

    public function __construct()
    {
        $this->exerciseSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(int $repetition): static
    {
        $this->repetition = $repetition;

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
            $exerciseSet->setSetRep($this);
        }

        return $this;
    }

    public function removeExerciseSet(ExerciseSet $exerciseSet): static
    {
        if ($this->exerciseSets->removeElement($exerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($exerciseSet->getSetRep() === $this) {
                $exerciseSet->setSetRep(null);
            }
        }

        return $this;
    }
    public function getSets(): ?int
    {
        return $this->sets;
    }

    public function setSets(?int $sets): void
    {
        $this->sets = $sets;
    }
    public function __toString(): string
    {
        // Retorne algo que identifique a série, ex: "Série 1" ou o ID
        return $this->sets . 'x' . $this->repetition;
    }
}
