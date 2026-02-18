<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Repository\ExerciseExecutionRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExerciseExecutionService
{
    public function __construct(
        private ExerciseExecutionRepository $repository,
        private EntityManagerInterface $entityManager
    ) {}

    public function get(int $id): ExerciseExecution
    {
        return $this->repository->find($id);
    }

    public function create(string $short, string $description): ExerciseExecution
    {
        if ($this->repository->findOneBy(['short' => $short])) {
            throw new \DomainException('Execução já existe.');
        }

        $execution = new ExerciseExecution();

        $execution->setShort($short);
        $execution->setDescription($description);

        $this->entityManager->persist($execution);
        $this->entityManager->flush();

        return $execution;
    }
}
