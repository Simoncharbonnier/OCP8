<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;

class TaskTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var $task task
     */
    private $task;

    /**
     * Set up before tests
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->task = new Task();
    }

    /**
     * Test id
     *
     * @return void
     */
    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    /**
     * Test created at
     *
     * @return void
     */
    public function testCreatedAt(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->task->getCreatedAt());

        $datetime = new \DateTime;
        $this->task->setCreatedAt($datetime);
        $this->assertSame($datetime, $this->task->getCreatedAt());
    }

    /**
     * Test is done
     *
     * @return void
     */
    public function testIsDone(): void
    {
        $this->assertFalse($this->task->isDone());

        $this->task->toggle(true);
        $this->assertTrue($this->task->isDone());
    }

    /**
     * Test title
     *
     * @return void
     */
    public function testTitle(): void
    {
        $this->assertNull($this->task->getTitle());

        $this->task->setTitle('Test title');
        $this->assertSame('Test title', $this->task->getTitle());
    }

    /**
     * Test content
     *
     * @return void
     */
    public function testContent(): void
    {
        $this->assertNull($this->task->getContent());

        $this->task->setContent('Test content');
        $this->assertSame('Test content', $this->task->getContent());
    }

    /**
     * Test user
     *
     * @return void
     */
    public function testUser(): void
    {
        $this->assertNull($this->task->getUser());

        $user = new User();
        $this->task->setUser($user);
        $this->assertSame($user, $this->task->getUser());
    }
}
