<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrmQueriesUcrType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('queryName', 'text', array(
                            'required'    => true,
                        ))
                ->add('queryText', 'textarea')
//                ->add('enable', 'choice', array(
//                    'choices' => array(
//                            'YES' => true,
//                            'NO'  => false,
//                    )
//                ))
                ->add('enable', 'choices', array(
                    'mapped'      => false,
                    'required'    => true,
                    'multiple'    => true,
                    'choices'     => array(
                        'Yes' => '1',
                        'No'  => '0',
                    )
                ))
                ->add('database', 'choice', array(
                    'mapped'    => false,
                    'required'  => true,
                    'choices'   => array(
                        'UCR'      => 'UCR',
                        'PICK'     => 'PICK',
                        'NEOLANE'  => 'NEOLANE',
                    )
                ))
                ->add('displayOrder')
                ->add('pageName', 'choice', array(
                            'required' => true,
                            'choices'  => array(
                                'UCR'      => 'UCR',
                                'PICK'     => 'PICK',
                                'NEOLANE'  => 'NEOLANE',
                            )
                      ));
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
