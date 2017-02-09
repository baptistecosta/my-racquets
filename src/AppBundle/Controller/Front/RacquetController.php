<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Racquet;
use AppBundle\Form\Type\RacquetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("racquets")
 */
class RacquetController extends Controller
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
        $form = $this->createForm(RacquetType::class, $racquet);

        return $this->render('front/racquet/read.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
