<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Testing\AbstractWebTestCase;
use AppBundle\Testing\RequestAsserter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests on users API
 */
class UserControllerTest extends AbstractWebTestCase
{
    /**
     * Tests "create" method
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testCreate()
    {
        $usersCount = $this->countTableRecords('User');

        $postedData = $this->parseFile(__DIR__.'/_posted/user/user_create.yml');

        $uri = $this->generateUrl('user.create');

        $requestAsserter = new RequestAsserter($this, $this->createClient());
        $requestAsserter
            ->post($uri, $postedData)
            ->expectStatusCode(Response::HTTP_CREATED);

        $this->assertEquals($usersCount + 1, $this->countTableRecords('User'));
    }
}
