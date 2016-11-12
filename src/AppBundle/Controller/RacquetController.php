<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Racquet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("racquets")
 */
class RacquetController extends AbstractController
{
    /**
     * @Route("/{id}")
     * @Method("GET")
     *
     * @param Racquet $racquet
     *
     * @return JsonResponse
     */
    public function getAction(Racquet $racquet)
    {
        return $this->createResponse($racquet, 'racquet.l');
    }
}
