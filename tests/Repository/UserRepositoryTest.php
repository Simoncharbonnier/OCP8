<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
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
        $repo = new UserRepository($this->createMock(ManagerRegistry::class));
        $this->assertInstanceOf(UserRepository::class, $repo);
    }

    /**
     * Test find all
     *
     * @return void
     */
    public function testFindAll(): void
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        $this->assertContainsOnly(User::class, $users);
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
