<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $racquetRepository = $em->getRepository('AppBundle:Racquet');

        $racquets = $racquetRepository->findAll();

        return $this->render('default/index.html.twig', ['racquets' => $racquets]);
    }
}
