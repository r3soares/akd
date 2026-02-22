<?php

namespace App\Tests\Service\EntityServices;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\Workout;
use App\Service\EntityServices\ExecutionService;
use App\Service\EntityServices\ExerciseExecutionService;
use App\Service\EntityServices\ExerciseService;
use App\Service\EntityServices\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExerciseExecutionServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ExerciseExecutionService $exerciseExecutionService;
    private ExerciseService $exerciseService;
    private ExecutionService $executionService;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->exerciseExecutionService = $container->get(ExerciseExecutionService::class);
        $this->exerciseService = $container->get(ExerciseService::class);
        $this->executionService = $container->get(ExecutionService::class);

        $this->entityManager->createQuery('DELETE FROM App\Entity\ExerciseExecution e')
            ->execute();
    }

    public function testSave(): void
    {
        // cria exercise necessário para relação
        $exercise =  $this->exerciseService->findAll()[0];
        $execution = $this->executionService->findAll()[0];


        $savedExecution = $this->exerciseExecutionService->create($exercise, $execution);

        $this->assertNotNull($savedExecution->getId());

        $found = $this->entityManager
            ->getRepository(ExerciseExecution::class)
            ->find($savedExecution->getId());

        $this->assertNotNull($found);
        $this->assertEquals($exercise->getId(), $found->getExercise()->getId());
    }

    public function testUpdate(): void
    {
        $exercise = new Exercise();
        $exercise->setName('Agachamento');

        $this->exerciseService->save($exercise);

        $execution = new ExerciseExecution();
        $execution->setExercise($exercise);

        // exemplo:
        // $execution->setRepetitions(10);

        $this->exerciseExecutionService->save($execution);

        // altera campo
        // exemplo:
        // $execution->setRepetitions(12);

        $this->exerciseExecutionService->save($execution);

        $found = $this->entityManager
            ->getRepository(ExerciseExecution::class)
            ->find($execution->getId());

        $this->assertNotNull($found);

        // exemplo:
        // $this->assertEquals(12, $found->getRepetitions());
    }

    public function testDelete(): void
    {
        $exercise = new Exercise();
        $exercise->setName('Levantamento Terra');

        $this->exerciseService->save($exercise);

        $execution = new ExerciseExecution();
        $execution->setExercise($exercise);

        $this->exerciseExecutionService->save($execution);

        $id = $execution->getId();

        $this->exerciseExecutionService->delete($execution);

        $found = $this->entityManager
            ->getRepository(ExerciseExecution::class)
            ->find($id);

        $this->assertNull($found);
    }
}
