<?php

namespace CIR\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dano', 'text', array(
                    'label' => 'DA: ',
                    'disabled' => true
                ))
            ->add('partno','text', array(
                    'label' => 'Part: ',
                    'disabled' => true
                ))
            ->add('batchno', 'text', array(
                    'label' => 'Batch: ',
                    'disabled' => true
                ))
            ->add('indate','date', array(
                    'label' => 'Date In: ',
                    'widget' => 'single_text',
                    'disabled' => true
                ))
            ->add('sub', 'collection', array(
                    'type' => new SubType(),
                    'label' => false,
                    'by_reference' => false,
//                    'prototype' => true,
//                    'allow_add' => true
                ))
            ->add('submit','submit')
        ;


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'CIR\Bundle\Entity\SumitomoMain',
            ));
    }

    public function getName()
    {
        return 'main';
    }
}