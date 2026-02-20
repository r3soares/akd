<?php

namespace App\Service\EntityServices;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @template TEntity of object
 */
abstract class AbstractEntityService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ValidatorInterface $validator,
    ) {}

    /**
     * @return ObjectRepository<TEntity>
     */
    abstract protected function getRepository(): ObjectRepository;

    protected function beforeSave(object $entity): void
    {}


    /**
     * @param TEntity $entity
     * @return TEntity
     */
    public function save(object $entity): object
    {
        $this->validate($entity);

        $this->beforeSave($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    /**
     * @return TEntity|null
     */
    public function find(int $id): ?object
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return TEntity
     */
    public function findOrFail(int $id): object
    {
        $entity = $this->find($id);

        if (!$entity) {
            throw new \RuntimeException(
                sprintf('%s not found', static::class)
            );
        }

        return $entity;
    }

    /**
     * @return list<TEntity>
     */
    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param TEntity $entity
     */
    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @param TEntity $entity
     */
    protected function validate(object $entity): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            throw new ValidationFailedException($entity, $errors);
        }
    }
}
