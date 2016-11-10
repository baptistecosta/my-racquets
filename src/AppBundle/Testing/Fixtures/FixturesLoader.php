<?php

namespace AppBundle\Testing\Fixtures;

use Doctrine\ORM\EntityManagerInterface;
use Nelmio\Alice\Fixtures;
use Symfony\Component\Yaml\Parser;

/**
 * Loads fixtures
 */
class FixturesLoader
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var array
     */
    private $references = [];

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Loads fixtures for tests
     */
    public function load()
    {
        $paths = [
            'base.yml',
        ];

        foreach ($paths as $path) {
            $references = Fixtures::load(
                sprintf(__DIR__.'/../../../../tests/_fixtures/%s', $path),
                $this->em
            );
            $this->references = array_merge($this->references, $references);
        }
    }

    /**
     * Returns an entity by its reference
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getEntityByReference($name)
    {
        return $this->references[$name];
    }

    /**
     * Parses a Yaml file
     *
     * @param string $path
     *
     * @return array
     */
    public function parseFile($path)
    {
        $yaml = new Parser();

        $data = $yaml->parse(file_get_contents($path));

        return FixturesReferenceReplacer::replace($data, $this->references);
    }

    /**
     * @return array
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param array $references
     */
    public function setReferences(array $references)
    {
        $this->references = $references;
    }
}
