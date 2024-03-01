<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testConstruct()
    {
        $repo = new UserRepository($this->createMock(ManagerRegistry::class));
        $this->assertInstanceOf(UserRepository::class, $repo);
    }

    public function testFindAll()
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        $this->assertContainsOnly(User::class, $users);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
