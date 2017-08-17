<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassUcrType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('startDate', 'date', array(
            'mapped'    => false,
            'label'     =>'Start date',
            'widget'    => 'single_text',
            'format'    => 'dd-MM-yyyy',
            'html5'     => false,
            'attr'      => ['class'         => 'form-control js-datepicker',
                'id'            => 'date',
                'name'          => 'date'],
            ))
            ->add('endDate', 'date', array(
                'mapped'    => false,
                'label'     =>'End date',
                'widget'    => 'single_text',
                'html5'     => false,
                'format'    => 'dd-MM-yyyy',
                'attr'      => ['class'         => 'form-control js-datepicker',
                    'id'            => 'date',
                    'name'          => 'date'],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CRM\ToolsBundle\Entity\ClassUcr'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'crm_toolsbundle_classucr';
    }


}
