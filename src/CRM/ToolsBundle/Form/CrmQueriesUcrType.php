<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrmQueriesUcrType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('searchBy', 'choice', array(
                    'mapped'    => false,
                    'label'     => 'Search By :',
                    'choices'   => array(
                            'ID_CONTACT' => 'ID_CONTACT',
                            'EMAIL'      => 'EMAIL',
                            'LEXO'       => 'LEXO',
                            'POLO'       => 'POLO',
                            'MIDAS'      => 'MIDAS',
                            'BBOSS'      => 'BBOSS'
                            )
                 ))
                ->add('searchText', 'text', array(
                    'mapped'      => false,
                    'required'    => false,
                ))

//                ->add('Please choose the environment', 'text', array(
//                    'mapped'    => false,
//                ))
//                ->add('Q3', 'radio',array(
//                    'mapped'  => false,
//                    'required'  => false,
//                ))
//                ->add('Q4', 'radio',array(
//                    'mapped'  => false,
//                    'required'  => false,
//                ))
//                ->add('Q5', 'radio',array(
//                    'mapped'  => false,
//                    'required'  => false,
//                ))
//                ->add('P1', 'radio',array(
//                    'mapped'  => false,
//                    'required'  => false,
//                ))
        ;




    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CRM\ToolsBundle\Entity\CrmQueriesUcr'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'crm_toolsbundle_crmqueriesucr';
    }


}
