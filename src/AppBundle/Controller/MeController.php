<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Me API
 *
 * @Route("/me")
 */
class MeController extends AbstractController
{
    /**
     * @Route()
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     *
     * @return Response
     */
    public function getAction()
    {
        return $this->createResponse($this->getUser(), 'user.l');
    }

    /**
     * @Route()
     * @Method("PUT")
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateAction(Request $request)
    {
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return new JsonResponse($this->get('app.form.utils')->getErrorsAsArray($form), 400);
        }

        // Encode password
        $user = $form->getData();
        if (!is_null($user->getPlainPassword())) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
        }

        $this->get('doctrine.orm.entity_manager')->flush();

        return $this->createResponse($user, 'user.l');
    }

    /**
     * @Route("/racquets")
     * @Method("GET")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return JsonResponse
     */
    public function myRacquetsAction()
    {
        $racquets = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Racquet')
            ->findBy(['user' => $this->getUser()]);

        return $this->createResponse($racquets, 'racquet.l');
    }
}
