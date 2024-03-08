<?php

namespace App\Tests\Security;

use App\Security\UserVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;

class UserVoterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var $voter voter
     */

    private $voter;

    /**
     * Set up before tests
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->voter = new UserVoter();
    }

    /**
     * @dataProvider provideCases
     * Test vote
     * @param string $attribute attribute
     * @param ?User $userSubject user subject
     * @param ?User $user user
     * @param $expected expected result
     *
     * @return void
     */
    public function testVote(string $attribute, ?User $userSubject, ?User $user, $expected): void
    {
        $token = $this->createMock(TokenInterface::class);
        if ($user) {
            $token->method('getUser')->willReturn($user);
        } else {
            $token->method('getUser')->willReturn(null);
        }

        $this->assertSame($expected, $this->voter->vote($token, $userSubject, [$attribute]));
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
                new User(),
                null,
                0
            ],
            [
                'view',
                null,
                null,
                0
            ],
            [
                'view',
                new User(),
                null,
                UserVoter::ACCESS_DENIED
            ],
            [
                'view',
                new User(),
                $this->createUser('simon'),
                UserVoter::ACCESS_DENIED
            ],
            [
                'view',
                new User(),
                $this->createUser('simon', ['ROLE_USER', 'ROLE_ADMIN']),
                UserVoter::ACCESS_GRANTED
            ],
            [
                'add',
                new User(),
                null,
                UserVoter::ACCESS_DENIED
            ],
            [
                'add',
                new User(),
                $this->createUser('simon'),
                UserVoter::ACCESS_DENIED
            ],
            [
                'add',
                new User(),
                $this->createUser('simon', ['ROLE_USER', 'ROLE_ADMIN']),
                UserVoter::ACCESS_GRANTED
            ],
            [
                'edit',
                new User(),
                null,
                UserVoter::ACCESS_DENIED
            ],
            [
                'edit',
                new User(),
                $this->createUser('simon'),
                UserVoter::ACCESS_DENIED
            ],
            [
                'edit',
                new User(),
                $this->createUser('simon', ['ROLE_USER', 'ROLE_ADMIN']),
                UserVoter::ACCESS_GRANTED
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

        return $user;
    }
}
