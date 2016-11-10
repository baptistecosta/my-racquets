<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * All controller must extend this abstract class
 *
 * @method User getUser()
 */
abstract class AbstractController extends Controller
{
    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @param mixed  $data
     * @param string $group
     *
     * @param int    $status
     * @return JsonResponse
     */
    protected function createResponse($data, $group, $status = JsonResponse::HTTP_OK)
    {
        return new JsonResponse(
            $this->get('app.group_serializer')->serialize($data, $group),
            $status,
            [],
            true
        );
    }
}
