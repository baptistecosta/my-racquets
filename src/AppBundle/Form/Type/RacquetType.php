<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Racquet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * RacquetType
 */
class RacquetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model')
            ->add('brand')
            ->add('string')
            ->add('dampener')
            ->add('overGrip')
            ->add('stringingPattern')
            ->add('staticWeight')
            ->add('headSize')
            ->add('balance')
            ->add('length')
            ->add('stiffness')
            ->add('beamWidth')
            ->add('swingWeight')
            ->add('twistWeight')
            ->add('recoilWeight')
            ->add('distanceToTopString')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Racquet::class,
        ]);
    }
}
