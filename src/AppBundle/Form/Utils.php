<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class Utils
 */
class Utils
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Get form errors in array
     *
     * @param FormInterface $form
     * @return array
     */
    public function getErrorsAsArray(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $key => $error) {
            $errors[$key] = $this->translator->trans(
                $error->getMessage(),
                $error->getMessageParameters(),
                'validators'
            );
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorsAsArray($child);
            }
        }

        return $errors;
    }

    /**
     * Convert constraint violations list to an array
     *
     * @param ConstraintViolationListInterface $constraintViolations
     * @return array
     */
    public function constraintViolationsToArray(ConstraintViolationListInterface $constraintViolations)
    {
        $errorMessages = [];
        foreach ($constraintViolations as $violation) {
            $errorMessages[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errorMessages;
    }
}
