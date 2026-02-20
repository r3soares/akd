<?php

namespace App\Service\EntityServices;

interface EntityServiceInterface
{
    /**
     * Persiste a entidade (create ou update)
     */
    public function save(object $entity): object;

    /**
     * Busca por ID
     */
    public function find(int $id): ?object;

    /**
     * Busca ou lança exceção
     */
    public function findOrFail(int $id): object;

    /**
     * Lista todas as entidades
     */
    public function findAll(): array;

    /**
     * Remove a entidade
     */
    public function delete(object $entity): void;
}
