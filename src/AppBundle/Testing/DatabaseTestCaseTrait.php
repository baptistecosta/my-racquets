<?php

namespace AppBundle\Testing;

use Doctrine\ORM\EntityManager;

/**
 * Adds database features to a test case
 *
 * @method EntityManager getEntityManager()
 */
trait DatabaseTestCaseTrait
{
    /**
     * Count table records
     *
     * @param string $entityName
     * @return mixed
     */
    protected function countTableRecords($entityName)
    {
        $em = $this->getEntityManager();

        if (!strstr($entityName, 'AppBundle')) {
            $entityName = sprintf('AppBundle:%s', $entityName);
        }

        $qb = $em->createQueryBuilder();
        $qb->select('count(a)');
        $qb->from($entityName, 'a');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param string $entityName
     * @param array  $criteria
     * @return null|object
     */
    protected function findOneBy($entityName, array $criteria = [])
    {
        if (!strstr($entityName, 'AppBundle')) {
            $entityName = sprintf('AppBundle:%s', $entityName);
        }

        $entity = $this->getEntityManager()
            ->getRepository($entityName)
            ->findOneBy($criteria);

        $this->getEntityManager()->refresh($entity);

        return $entity;
    }
}
