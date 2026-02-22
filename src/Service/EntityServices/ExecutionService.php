<?php

namespace App\Service\EntityServices;

use App\Entity\Execution;
use App\Repository\ExecutionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @extends AbstractEntityService<Execution>
 */
class ExecutionService extends AbstractEntityService
{
    public function __construct(
        private ExecutionRepository $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        parent::__construct($entityManager, $validator);
    }

    protected function getRepository(): ExecutionRepository
    {
        return $this->repository;
    }

    /**
     * Cria uma nova execução
     */
    public function create(
        string $name,
        ?string $description = null
    ): Execution {

        $execution = new Execution();
        $execution->setName($name);
        $execution->setDescription($description);

        return $this->save($execution);
    }

    /**
     * Atualiza uma execução existente
     */
    public function update(
        Execution $execution,
        string $name,
        ?string $description = null
    ): Execution {

        $execution->setName(trim($name));
        $execution->setDescription($description);

        return $this->save($execution);
    }

}
