<?php

namespace AppBundle\Testing\Fixtures;

use AppBundle\Entity\User;

/**
 * Adds fixtures features to a test case
 *
 * @method object getService($id)
 */
trait FixturesTestCaseTrait
{
    /**
     * @var FixturesLoader
     */
    protected $fixturesLoader;

    /**
     * @return FixturesLoader
     */
    public function getFixturesLoader()
    {
        return $this->fixturesLoader;
    }

    /**
     * @param array $references
     */
    public function initFixturesLoader(array $references)
    {
        $this->fixturesLoader = $this->getService('app.testing.fixtures_loader');
        $this->fixturesLoader->setReferences($references);
    }

    /**
     * Purges database and loads fixtures
     */
    protected function purgeDatabaseAndLoadFixtures()
    {
        $purger = $this->getService('app.testing.purger');
        $purger->purge();

        $this->fixturesLoader = $this->getService('app.testing.fixtures_loader');
        $this->fixturesLoader->load();
    }

    /**
     * Parses a Yaml file and replace references if needed
     *
     * @param $path
     *
     * @return mixed
     */
    protected function parseFile($path)
    {
        return $this->fixturesLoader->parseFile($path);
    }

    /**
     * @param string $name
     * @return User
     */
    protected function loadUser($name)
    {
        return $this->fixturesLoader->getEntityByReference(sprintf('user.%s', $name));
    }
}
