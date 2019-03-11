<?php

namespace CIR\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id','hidden')
            ->add('shipdate','date', array(
                    'widget' => 'single_text',
                    'label' => 'Date Out: '
                ))
            ->add('qtyshipped','integer', array(
                    'label' => 'Qty Out: '
                ))
            ->add('blno','text', array(
                    'label' => 'BL: '
                ))
            ->add('submit','submit')
        ;


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'CIR\Bundle\Entity\SumitomoLog',
            ));
    }

    public function getName()
    {
        return 'log';
    }
}