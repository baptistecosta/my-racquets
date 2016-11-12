<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Testing\AbstractWebTestCase;
use AppBundle\Testing\RequestAsserter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests on racquets API
 */
class RacquetControllerTest extends AbstractWebTestCase
{
    /**
     * Tests "get" action
     *
     * @purgeDatabaseAndLoadFixtures
     */
    public function testGet()
    {
        $request = new RequestAsserter($this, $this->createClient());
        $request
            ->get('/racquets/1')
            ->expectStatusCode(Response::HTTP_OK)
            ->expectJsonContentFromYaml(__DIR__.'/_expected/racquet/racquet_get.yml');
    }
}
