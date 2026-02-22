<?php

declare(strict_types=1);

namespace App\Tests\Service\EntityServices;

use App\Entity\Execution;
use App\Entity\Workout;
use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\WorkoutExercise;
use App\Service\EntityServices\WorkoutExerciseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function PHPUnit\Framework\assertNotNull;

class WorkoutExerciseServiceTest extends KernelTestCase
{
    private WorkoutExerciseService $service;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->service = $container->get(WorkoutExerciseService::class);
        $this->em = $container->get(EntityManagerInterface::class);

        // Limpa tabelas relacionadas antes de cada teste
        $this->em->createQuery('DELETE FROM App\Entity\WorkoutExercise we')->execute();
        $this->em->createQuery('DELETE FROM App\Entity\Workout w')->execute();
        $this->em->createQuery('DELETE FROM App\Entity\ExerciseExecution ee')->execute();
        $this->em->createQuery('DELETE FROM App\Entity\Exercise e')->execute();
    }

    public function testAddWorkoutExerciseWithPosition(): void
    {
        $workout = new Workout();
        $workout->setName('Treino A');
        $exercise = new Exercise();
        $exercise->setName('Supino');
        $execution = new Execution();
        $execution->setName('3x10');

        $exerciseExecution = new ExerciseExecution();
        $exerciseExecution->setExercise($exercise);
        $exerciseExecution->setExecution($execution);

        $workoutExercise = $this->service->create($workout,$exerciseExecution, 2);

        $this->assertInstanceOf(WorkoutExercise::class, $workoutExercise);
        $this->assertSame($exerciseExecution, $workoutExercise->getExerciseExecution());
        $this->assertSame(2, $workoutExercise->getPosition());
    }

    public function testAddWorkoutExerciseWithoutPosition(): void
    {
        $workout = new Workout();
        $workout->setName('Treino A');
        $exercise = new Exercise();
        $exercise->setName('Supino');
        $execution = new Execution();
        $execution->setName('3x10');

        $exerciseExecution = new ExerciseExecution();
        $exerciseExecution->setExercise($exercise);
        $exerciseExecution->setExecution($execution);

        $workoutExercise = $this->service->create($workout,$exerciseExecution,null);

        $this->assertInstanceOf(WorkoutExercise::class, $workoutExercise);
        $this->assertSame($exerciseExecution, $workoutExercise->getExerciseExecution());
        $this->assertNotNull($workoutExercise->getPosition());
    }

    public function testPositionCannotBeLowerThanOne(): void
    {
        $workout = new Workout();
        $workout->setName('Treino A');
        $exercise = new Exercise();
        $exercise->setName('Supino');
        $execution = new Execution();
        $execution->setName('3x10');

        $exerciseExecution = new ExerciseExecution();
        $exerciseExecution->setExercise($exercise);
        $exerciseExecution->setExecution($execution);

        $workoutExercise = $this->service->create($workout, $exerciseExecution, 0);

        $this->assertGreaterThanOrEqual(1, $workoutExercise->getPosition(), "A posição mínima deve ser 1");
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
    }
}
