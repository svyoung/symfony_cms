<?php

namespace CIR\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SumitomoMainType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dano','text', array(
                    'label' => 'DA'
                ))
            ->add('partno','text', array(
                    'label' => 'Part'
                ))
            ->add('batchno','text', array(
                    'label' => 'Batch'
                ))
            ->add('indate','date', array(
                    'label' => 'Date',
                    'widget' => 'single_text'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CIR\Bundle\Entity\SumitomoMain'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cir_bundle_sumitomomain';
    }
}
