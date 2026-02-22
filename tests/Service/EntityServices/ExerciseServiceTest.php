<?php

declare(strict_types=1);

namespace App\Tests\Service\EntityServices;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use App\Service\EntityServices\ExerciseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

class ExerciseServiceTest extends KernelTestCase
{
    private ExerciseService $service;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->service = $container->get(ExerciseService::class);
        $em = $container->get(EntityManagerInterface::class);

        // limpa tabela antes de cada teste
        $em->createQuery('DELETE FROM App\Entity\Exercise e')
            ->execute();
    }

    public function testCreateExercise(): void
    {
        $exercise = $this->service->create('Supino');

        $this->assertInstanceOf(Exercise::class, $exercise);
        $this->assertEquals('supino', $exercise->getName());
        $this->assertNotNull($exercise->getId());
    }

    public function testCreateExerciseTrim(): void
    {
        $exercise = $this->service->create('  Agachamento  ');

        $this->assertEquals('agachamento', $exercise->getName());
    }

    public function testCreateExerciseValidationFails(): void
    {
        $this->expectException(ValidationFailedException::class);

        $this->service->create('');
    }

    public function testUpdateExercise(): void
    {
        $exercise = $this->service->create('Supino');

        $updated = $this->service->update($exercise, 'Supino Inclinado');

        $this->assertEquals('supino inclinado', $updated->getName());
    }

    public function testFindExercise(): void
    {
        $exercise = $this->service->create('Barra Fixa');

        $found = $this->service->find($exercise->getId());

        $this->assertEquals($exercise->getId(), $found->getId());
    }

    public function testFindAllExercises(): void
    {
        $this->service->create('Supino');
        $this->service->create('Agachamento');

        $all = $this->service->findAll();

        $this->assertCount(2, $all);
    }

    public function testDeleteExercise(): void
    {
        $exercise = $this->service->create('Remada');
        $id = $exercise->getId();
        $this->service->delete($exercise);

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
