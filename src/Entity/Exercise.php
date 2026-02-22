<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
#[UniqueEntity('name', message: 'Já existe um exercício com este nome.')]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128, unique: true)]
    #[Assert\NotBlank(message: 'O nome não pode ser vazio')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, ExerciseExecution>
     */
    #[ORM\OneToMany(targetEntity: ExerciseExecution::class, mappedBy: 'exercise', orphanRemoval: true)]
    private Collection $exerciseExecutions;

    public function __construct()
    {
        $this->exerciseExecutions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description !== null ? trim($description) : null;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    /**
     * @return Collection<int, ExerciseExecution>
     */
    public function getExerciseExecutions(): Collection
    {
        return $this->exerciseExecutions;
    }

    public function addExerciseExecution(ExerciseExecution $exerciseExecution): static
    {
        if (!$this->exerciseExecutions->contains($exerciseExecution)) {
            $this->exerciseExecutions->add($exerciseExecution);
            $exerciseExecution->setExercise($this);
        }

        return $this;
    }

    public function removeExerciseExecution(ExerciseExecution $exerciseExecution): static
    {
        if ($this->exerciseExecutions->removeElement($exerciseExecution)) {
            // set the owning side to null (unless already changed)
            if ($exerciseExecution->getExercise() === $this) {
                $exerciseExecution->setExercise(null);
            }
        }

        return $this;
    }
}
