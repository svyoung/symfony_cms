<?php

namespace CIR\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rackno','text', array(
                    'label' => 'Rack No(s): ',
                ))
            ->add('heatcode','text', array(
                    'label' => 'Heat Code: ',
                    'required' => false
                ))
            ->add('diecode','text', array(
                    'label' => 'Die Code: ',
                    'required' => false
                ))
            ->add('inqty','integer', array(
                    'label' => 'Qty In: '
                ))
            ->add('onhold','choice', array(
                    'label' => 'Hold',
                    'choices' => array(
                        '1' => 'On Hold',
                        '0' => 'Released'
                    ),
                    'multiple' => false,
                    'expanded' => true
                ))


        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'CIR\Bundle\Entity\SumitomoSub',
            ));
    }

    public function getName()
    {
        return 'sub';
    }
}