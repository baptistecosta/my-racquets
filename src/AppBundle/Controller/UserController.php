<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User API
 *
 * @Route("/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user.create")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(UserType::class, null, ['validation_groups' => 'signup']);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return new JsonResponse($this->get('app.form.utils')->getErrorsAsArray($form), 400);
        }

        $user = $form->getData();
        $this->get('app.user.registrator')->signUp($user);

        return $this->createResponse($user, 'user.l', Response::HTTP_CREATED);
    }
}
