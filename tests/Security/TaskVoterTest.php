<?php

namespace App\Tests\Security;

use App\Security\TaskVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use App\Entity\Task;

class TaskVoterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var $voter voter
     */
    private $voter;

    /**
     * @var $lastUser last user
     */
    private $lastUser;

    /**
     * Set up before tests
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->voter = new TaskVoter();
        $this->lastUser = null;
    }

    /**
     * @dataProvider provideCases
     * Test vote
     * @param string $attribute attribute
     * @param ?Task $task task
     * @param ?User $user user
     * @param $expected expected result
     *
     * @return void
     */
    public function testVote(string $attribute, ?Task $task, ?User $user, $expected): void
    {
        $token = $this->createMock(TokenInterface::class);
        if ($user) {
            $token->method('getUser')->willReturn($user);
        } else {
            $token->method('getUser')->willReturn(null);
        }

        $this->assertSame($expected, $this->voter->vote($token, $task, [$attribute]));
    }

    /**
     * Provide cases
     *
     * @return array
     */
    public function provideCases(): array
    {
        return [
            [
                'false',
                new Task(),
                null,
                0
            ],
            [
                'add',
                null,
                null,
                0
            ],
            [
                'add',
                new Task(),
                null,
                TaskVoter::ACCESS_DENIED
            ],
            [
                'add',
                new Task(),
                $this->createUser('simon'),
                TaskVoter::ACCESS_GRANTED
            ],
            [
                'edit',
                $this->createTask($this->createUser('simon')),
                null,
                TaskVoter::ACCESS_DENIED
            ],
            [
                'edit',
                $this->createTask($this->createUser('simon')),
                $this->createUser('john'),
                TaskVoter::ACCESS_DENIED
            ],
            [
                'edit',
                $this->createTask($this->createUser('simon')),
                $this->lastUser,
                TaskVoter::ACCESS_GRANTED
            ],
            [
                'edit',
                $this->createTask($this->createUser('simon')),
                $this->createUser('john', ['ROLE_USER', 'ROLE_ADMIN']),
                TaskVoter::ACCESS_DENIED
            ],
            [
                'edit',
                $this->createTask($this->createUser('anonyme')),
                $this->createUser('john', ['ROLE_USER', 'ROLE_ADMIN']),
                TaskVoter::ACCESS_GRANTED
            ],
            [
                'delete',
                $this->createTask($this->createUser('simon')),
                null,
                TaskVoter::ACCESS_DENIED
            ],
            [
                'delete',
                $this->createTask($this->createUser('simon')),
                $this->createUser('john'),
                TaskVoter::ACCESS_DENIED
            ],
            [
                'delete',
                $this->createTask($this->createUser('simon')),
                $this->lastUser,
                TaskVoter::ACCESS_GRANTED
            ],
            [
                'delete',
                $this->createTask($this->createUser('simon')),
                $this->createUser('john', ['ROLE_USER', 'ROLE_ADMIN']),
                TaskVoter::ACCESS_DENIED
            ],
            [
                'delete',
                $this->createTask($this->createUser('anonyme')),
                $this->createUser('john', ['ROLE_USER', 'ROLE_ADMIN']),
                TaskVoter::ACCESS_GRANTED
            ]
        ];
    }

    /**
     * Create user
     * @param string $username username
     * @param array $roles roles
     *
     * @return User
     */
    private function createUser(string $username, array $roles = ['ROLE_USER']): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setRoles($roles);

        $this->lastUser = $user;

        return $user;
    }

    /**
     * Create Task
     * @param User $user user
     *
     * @return Task
     */
    private function createTask(User $user): Task
    {
        $task = new Task();
        $task->setUser($user);

        return $task;
    }
}
