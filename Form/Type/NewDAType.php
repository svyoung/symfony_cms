<?php

namespace CIR\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewDAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dano', 'text', array(
                    'label' => 'DA # '
                ))
            ->add('partno','text', array(
                    'label' => 'Part # '
                ))
            ->add('batchno','text', array(
                    'label' => 'Batch # '
                ))
            ->add('indate','date', array(
                    'label' => 'Date In ',
                    'widget' => 'single_text',
                    'attr' => array('class' => 'date')
                ))
            ->add('Submit', 'submit');
    }

    public function getName()
    {
        return 'newda';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'CIR\Bundle\Entity\SumitomoMain',
            ));
    }

}