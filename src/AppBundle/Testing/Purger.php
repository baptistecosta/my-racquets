<?php

namespace AppBundle\Testing;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Purges database
 */
class Purger
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

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
     * Purges database
     */
    public function purge()
    {
        $connection = $this->em->getConnection();

        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);

        try {
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');
            $purger->purge();
        } finally {
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');
        }

        $tables = [
            'brand',
            'dampener',
            'over_grip',
            'racquet',
            'racquet_model',
            'racquet_string',
            'racquet_string_type',
            'stringing_pattern',
            'user',
        ];

        $connection = $this->em->getConnection();

        foreach ($tables as $table) {
            $connection->exec(sprintf("ALTER TABLE %s AUTO_INCREMENT = 1;", $table));
        }
    }
}
