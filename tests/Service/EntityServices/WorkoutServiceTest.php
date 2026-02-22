<?php

namespace App\Tests\Service\EntityServices;

use App\Entity\Workout;
use App\Service\EntityServices\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkoutServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private WorkoutService $workoutService;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->workoutService = $container->get(WorkoutService::class);

        $this->entityManager->createQuery('DELETE FROM App\Entity\Workout e')
            ->execute();
    }

    public function testSaveCreatesWorkout(): void
    {
        $workout = new Workout();
        $workout->setName('Treino A');

        $savedWorkout = $this->workoutService->save($workout);

        // verifica se o ID foi gerado
        $this->assertNotNull($savedWorkout->getId());

        // verifica se foi salvo corretamente
        $this->assertEquals('treino a', $savedWorkout->getName());

        // verifica se realmente está no banco
        $found = $this->entityManager
            ->getRepository(Workout::class)
            ->find($savedWorkout->getId());

        $this->assertNotNull($found);
        $this->assertEquals('treino a', $found->getName());
    }

    public function testDeleteWorkout(): void
    {
        $workout = new Workout();
        $workout->setName('Treino A');

        $this->workoutService->save($workout);

        $id = $workout->getId();

        $this->workoutService->delete($workout);

        $found = $this->entityManager
            ->getRepository(Workout::class)
            ->find($id);

        $this->assertNull($found);
    }
}
