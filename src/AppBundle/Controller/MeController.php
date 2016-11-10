<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Form\Type\AddressType;
use AppBundle\Form\Type\UserType;
use AppBundle\Entity\Request as AppRequest;
use AppBundle\Form\Type\RequestType;
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
        $user = $this->getUser();

        return $this->createResponse($user, 'user.l');
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
     * @Route("/requests", name="my_requests")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     * @return Response
     */
    public function listMyRequestsAction()
    {
        return $this->createResponse(
            $this->getUser()->getRequests(),
            'request.s'
        );
    }

    /**
     * @Route("/requests")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createRequestAction(Request $request)
    {
        $appRequest = (new AppRequest())
            ->setUser($this->getUser())
            ->setPrice(10)
            ->setCreatedAt(new \DateTime());

        $form = $this
            ->createForm(RequestType::class, $appRequest)
            ->submit($request->request->all());

        if (!$form->isValid()) {
            return new JsonResponse($this->get('app.form.utils')->getErrorsAsArray($form), 400);
        }

        $this->getEntityManager()->persist($appRequest);
        $this->getEntityManager()->flush();

        return $this->createResponse(
            $appRequest,
            'request.l',
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/address")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addAddressAction(Request $request)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return new JsonResponse($this->get('app.form.utils')->getErrorsAsArray($form), 400);
        }

        $address->setUser($this->getUser());

        $entityManager = $this->get('doctrine.orm.entity_manager');
        $entityManager->persist($address);
        $entityManager->flush();

        return $this->createResponse($address, 'address.l', Response::HTTP_CREATED);
    }
}
