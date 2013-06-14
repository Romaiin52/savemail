<?php

namespace rm\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object','text')
            ->add('content','textarea')
            ->add('isFavorite','checkbox', array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'rm\EmailBundle\Entity\Email'
        ));
    }

    public function getName()
    {
        return 'rm_emailbundle_emailtype';
    }
}
