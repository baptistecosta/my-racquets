<?php

namespace AppBundle\Service\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Registers a user (if not exist)
 */
class Registrator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @param EntityManagerInterface $entityManager
     * @param EncoderFactory         $encoderFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EncoderFactory $encoderFactory
    ) {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param User $user
     */
    public function signUp(User $user)
    {
        // Create user if it does not already exist in database
        if (!$this->entityManager->getRepository('AppBundle:User')->findOneByEmail($user->getEmail())) {
            $encoder = $this->getEncoder($user);
            $password = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    /**
     * @param UserInterface $user
     * @return PasswordEncoderInterface
     */
    private function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }
}
