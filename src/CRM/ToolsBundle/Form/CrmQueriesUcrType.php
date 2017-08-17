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
        $builder ->add('SearchBy', 'choice', array(
                    'mapped'    => false,
                    'label'   => 'Search By :',
                    'choices' => array(
                            'ID_CONTACT' => 'ID_CONTACT',
                            'EMAIL'      => 'EMAIL',
                            'LEXO'       => 'LEXO',
                            'POLO'       => 'POLO',
                            'MIDAS'      => 'MIDAS',
                            'BBOSS'      => 'BBOSS'
                            )
                 ))
                 ->add('search', 'text', array(
                            'mapped'      => false,
                            'required'    => true
                 ))
//                ->add('Please choose the environment:')



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
