<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;
use App\Entity\User;
use App\Entity\Task;

class TaskControllerTest extends WebTestCase
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
     * Set up before tests functions
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Test list action
     *
     * @return void
     */
    public function testListAction(): void
    {
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test create action
     *
     * @return void
     */
    public function testCreateAction(): void
    {
        $user = $this->createUser('user');
        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Titre';
        $form['task[content]'] = 'Contenu';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $this->cleanDb();
    }

    /**
     * Test edit action
     *
     * @return void
     */
    public function testEditAction(): void
    {
        $user = $this->createUser('user');
        $taskId = $this->createTask($user);

        $this->client->loginUser($user);
        $crawler = $this->client->request('GET', '/tasks/'.$taskId.'/edit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Titre modifié';
        $form['task[content]'] = 'Contenu modifié';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $this->cleanDb();
    }

    /**
     * Test toggle task action
     *
     * @return void
     */
    public function testToggleTaskAction(): void
    {
        $user = $this->createUser('user');
        $taskId = $this->createTask($user);

        $this->client->loginUser($user);
        $this->client->request('GET', '/tasks/'.$taskId.'/toggle');

        $crawler = $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

        $this->cleanDb();
    }

    /**
     * Test delete task action
     *
     * @return void
     */
    public function testDeleteTaskAction(): void
    {
        $user = $this->createUser('user');
        $taskId = $this->createTask($user);

        $this->client->loginUser($user);
        $this->client->request('GET', '/tasks/'.$taskId.'/delete');

        $crawler = $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

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
        $user->setPassword('secret');
        $user->setEmail('test@example.com');

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * Create task
     * @param User $user user
     *
     * @return int
     */
    private function createTask(User $user): int
    {
        $task = new Task();
        $task->setUser($user);
        $task->setTitle('Titre');
        $task->setContent('Contenu');

        $this->manager->persist($task);
        $this->manager->flush();

        return $task->getId();
    }

    /**
     * Clean db
     *
     * @return void
     */
    private function cleanDb(): void
    {
        $this->manager->getConnection()->query('DELETE FROM task');
        $this->manager->getConnection()->query('DELETE FROM user');
    }
}
