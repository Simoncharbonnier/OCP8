<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;
use App\Entity\User;

class SecurityControllerTest extends WebTestCase
{

    /**
     * @var $client client
     */
    private $client;

    /**
     * @var $manager entity manager
     */
    private $manager;

    /**
     * @var $hasher password hasher
     */
    private $hasher;

    /**
     * Set up before tests functions
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->hasher = $this->client->getContainer()->get('security.user_password_hasher');
    }

    /**
     * @dataProvider provideCases
     * Test login
     * @param $createUser create user or not
     * @param $password password
     * @param $expectedLogin expected login or not
     *
     * @return void
     */
    public function testLogin($createUser, $password, $expectedLogin): void
    {
        if ($createUser) {
            $user = $this->createUser('user');
        }

        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user';
        $form['_password'] = $password;
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        if ($expectedLogin) {
            $this->assertSame('Se déconnecter', $crawler->filter('a.pull-right.btn.btn-danger')->text());
        } else {
            $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
        }

        $this->cleanDb();
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
        $user->setPassword($this->hasher->hashPassword($user, 'secret'));
        $user->setEmail('test@example.com');

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * Clean db
     *
     * @return void
     */
    private function cleanDb(): void
    {
        $this->manager->getConnection()->query('DELETE FROM user');
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
                true,
                'secret',
                true
            ],
            [
                false,
                'secret',
                false
            ],
            [
                true,
                'secrete',
                false
            ]
        ];
    }
}
