<?php

namespace App\Entity;

use App\Repository\SetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SetRepository::class)]
class Set
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $repetition = null;

    #[ORM\Column(nullable: true)]
    private ?int $load = null;

    #[ORM\Column(nullable: true)]
    private ?int $restTime = null;

    /**
     * @var Collection<int, ExerciseSet>
     */
    #[ORM\OneToMany(targetEntity: ExerciseSet::class, mappedBy: 'set')]
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

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(int $repetition): static
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getLoad(): ?int
    {
        return $this->load;
    }

    public function setLoad(?int $load): static
    {
        $this->load = $load;

        return $this;
    }

    public function getRestTime(): ?int
    {
        return $this->restTime;
    }

    public function setRestTime(?int $restTime): static
    {
        $this->restTime = $restTime;

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
            $exerciseSet->setSet($this);
        }

        return $this;
    }

    public function removeExerciseSet(ExerciseSet $exerciseSet): static
    {
        if ($this->exerciseSets->removeElement($exerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($exerciseSet->getSet() === $this) {
                $exerciseSet->setSet(null);
            }
        }

        return $this;
    }
}
