<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
    /**
     * @var $entityManager entity manager
     */

    private $entityManager;

    /**
     * Set up before tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Test construct
     *
     * @return void
     */
    public function testConstruct(): void
    {
        $repo = new TaskRepository($this->createMock(ManagerRegistry::class));
        $this->assertInstanceOf(TaskRepository::class, $repo);
    }

    /**
     * Test find all
     *
     * @return void
     */
    public function testFindAll(): void
    {
        $tasks = $this->entityManager
            ->getRepository(Task::class)
            ->findAll();

        $this->assertContainsOnly(Task::class, $tasks);
    }

    /**
     * Tear down after tests
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
