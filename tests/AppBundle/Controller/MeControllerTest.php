<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Testing\AbstractWebTestCase;
use AppBundle\Testing\RequestAsserter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests on "me" API
 */
class MeControllerTest extends AbstractWebTestCase
{
    /**
     * Tests "get" method
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testGet()
    {
        $client = static::createAuthenticatedClient(User::EMAIL_BAPTISTE);

        $asserter = new RequestAsserter($this, $client);
        $asserter
            ->get('/me')
            ->expectStatusCode(Response::HTTP_OK)
            ->expectJsonContent($this->parseFile(__DIR__.'/_expected/me/me_get.yml'));
    }

    /**
     * Tests "update" method with a new password given
     */
    public function testUpdateWithPassword()
    {
        $user = $this->fixturesLoader->getEntityByReference('user.baptiste');
        $usersCount = $this->countTableRecords('User');

        $client = static::createAuthenticatedClient($user->getEmail());
        $requestAsserter = new RequestAsserter($this, $client);
        $requestAsserter
            ->put('/me', $this->parseFile(__DIR__.'/_posted/me/me_update_with_password.yml'))
            ->expectStatusCode(Response::HTTP_OK);

        $this->assertEquals($usersCount, $this->countTableRecords('User'));

        $user = $this->findOneBy('User', ['id' => $user->getId()]);
        $this->assertEquals('Costo', $user->getFirstname());
        $this->assertEquals('Bautista', $user->getLastname());
        $this->assertEquals('baptiste.costa@gmail.com', $user->getEmail());

        // Check password
        $encoder = $this->getService('security.encoder_factory')->getEncoder($user);
        $this->assertTrue($encoder->isPasswordValid(
            $user->getPassword(),
            'new_password',
            $user->getSalt()
        ));
    }

    /**
     * Tests "update" method without password
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testUpdateWithoutPassword()
    {
        $user = $this->fixturesLoader->getEntityByReference('user.baptiste');
        $currentPassword = $user->getPassword();

        $client = static::createAuthenticatedClient($user->getEmail());
        $requestAsserter = new RequestAsserter($this, $client);
        $requestAsserter
            ->put('/me', $this->parseFile(__DIR__.'/_posted/me/me_update_without_password.yml'))
            ->expectStatusCode(Response::HTTP_OK);

        $this->assertEquals($currentPassword, $user->getPassword());
    }

    /**
     * Test "myRaquets" action
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testMyRacquets()
    {
        $client = static::createAuthenticatedClient(User::EMAIL_BAPTISTE, 'testtest');

        $asserter = new RequestAsserter($this, $client);
        $asserter
            ->get('/me/racquets')
            ->expectStatusCode(Response::HTTP_OK)
            ->expectJsonContentFromYaml(__DIR__.'/_expected/me/my_racquets.yml');
    }

    /**
     * Test "createRacquet" action
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testCreateRacquet()
    {
        $client = static::createAuthenticatedClient(User::EMAIL_BAPTISTE, 'testtest');

        $asserter = new RequestAsserter($this, $client);
        $asserter
            ->post('/me/racquets', $this->parseFile(__DIR__.'/_posted/me/me_create_racquet.yml'))
            ->expectStatusCode(Response::HTTP_CREATED)
            ->expectJsonContentFromYaml(__DIR__.'/_expected/me/me_create_racquet.yml');
    }
}
