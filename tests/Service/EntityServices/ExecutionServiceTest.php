<?php

declare(strict_types=1);

namespace App\Tests\Service\EntityServices;

use App\Repository\ExecutionRepository;
use App\Service\EntityServices\ExecutionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExecutionServiceTest extends KernelTestCase
{
    private ExecutionService $service;
    private EntityManagerInterface $em;
    private ExecutionRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->service = $container->get(ExecutionService::class);
        $em = $container->get(EntityManagerInterface::class);

        // limpa tabela antes de cada teste
        $em->createQuery('DELETE FROM App\Entity\Execution e')
            ->execute();
    }

    public function testCreateExecution(): void
    {
        $execution = $this->service->create(
            '3x8',
            '4 segundos em cada execução'
        );

        $this->assertEquals('3x8', $execution->getName());
        $this->assertEquals(
            '4 segundos em cada execução',
            $execution->getDescription()
        );
        $this->assertNotNull($execution->getId());
    }

    public function testCreateExecutionTrim(): void
    {
        $execution = $this->service->create(
            '  Máquina  ',
            '  Descrição teste  '
        );

        $this->assertEquals('máquina', $execution->getName());
        $this->assertEquals('Descrição teste', $execution->getDescription());
    }

    public function testCreateExecutionValidationFails(): void
    {
        $this->expectException(ValidationFailedException::class);

        $this->service->create('');
    }

    public function testUpdateExecution(): void
    {
        $execution = $this->service->create('Barra');

        $updated = $this->service->update(
            $execution,
            'Barra Guiada',
            'Execução na máquina Smith'
        );

        $this->assertEquals('barra guiada', $updated->getName());
        $this->assertEquals(
            'Execução na máquina Smith',
            $updated->getDescription()
        );
    }

    public function testFindExecution(): void
    {
        $execution = $this->service->create('Peso Corporal');

        $found = $this->service->find($execution->getId());

        $this->assertEquals($execution->getId(), $found->getId());
    }

    public function testFindAllExecutions(): void
    {
        $this->service->create('Barra');
        $this->service->create('Máquina');

        $all = $this->service->findAll();

        $this->assertCount(2, $all);
    }

    public function testDeleteExecution(): void
    {
        $execution = $this->service->create('Remada');

        $id = $execution->getId();

        $this->service->delete($execution);

        $this->assertNull(
            $this->service->find($id)
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
    }
}
