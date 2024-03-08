<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Task;

class UserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var $user user
     */

    private $user;

    /**
     * Set up before tests
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * Test id
     *
     * @return void
     */
    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    /**
     * Test username
     *
     * @return void
     */
    public function testUsername(): void
    {
        $this->assertNull($this->user->getUsername());

        $this->user->setUsername('simon');
        $this->assertSame('simon', $this->user->getUsername());
    }

    /**
     * Test password
     *
     * @return void
     */
    public function testPassword(): void
    {
        $this->assertNull($this->user->getPassword());

        $this->user->setPassword('secret');
        $this->assertSame('secret', $this->user->getPassword());
    }

    /**
     * Test email
     *
     * @return void
     */
    public function testEmail(): void
    {
        $this->assertNull($this->user->getEmail());

        $this->user->setEmail('simon.charbonnier@gmail.com');
        $this->assertSame('simon.charbonnier@gmail.com', $this->user->getEmail());
    }

    /**
     * Test tasks
     *
     * @return void
     */
    public function testTasks(): void
    {
        $this->assertEmpty($this->user->getTasks());

        $task = new Task();
        $this->user->addTask($task);
        $this->assertContains($task, $this->user->getTasks());

        $this->user->removeTask($task);
        $this->assertEmpty($this->user->getTasks());
    }

    /**
     * Test roles
     *
     * @return void
     */
    public function testRoles(): void
    {
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());

        $this->user->setRoles(['ROLE_ADMIN']);
        $this->assertSame(['ROLE_ADMIN', 'ROLE_USER'], $this->user->getRoles());
    }

    /**
     * Test salt
     *
     * @return void
     */
    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    /**
     * Test erase credentials
     *
     * @return void
     */
    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

    /**
     * Test user identifier
     *
     * @return void
     */
    public function testUserIdentifier(): void
    {
        $this->user->setUsername('simon');
        $this->assertSame('simon', $this->user->getUserIdentifier());
    }
}
