<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrmQueriesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('queryName', 'text', array(
                        'required'    => true,
                     ))
                ->add('queryText', 'textarea', array(
                    'required'    => true,
                ))
                ->add('groupName', 'choice', array(
                        'required' => true,
                        'choices' => array(
                            'Qualite Reference'      => 'Qualite Reference',
                            'Qualite UCR'            => 'Qualite UCR',
                            'Qualite anonymisation'  => 'Qualite anonymisation',
                            'Qualite proprietaire'   => 'Qualite proprietaire',
                            'Qualité PV'             => 'Qualité PV',
                            'Qualite MIDAS'          => 'Qualite MIDAS',
                        )
                     ))
                ->add('description','text', array(
                            'required'    => true,
                ))
                ->add('enableHistory','choice', array(
                            'expanded'  => true,
                            'multiple'  => false,
                            'required'    => true,
                            'choices'     => array(
                                'Yes' => 'Yes',
                                'No'  => 'No',
                            )
                    ))
                ->add('database', 'choice', array(
                            'mapped'    => false,
                            'choices' => array(
                                'UCR'      => 'UCR',
                                'PICK'     => 'PICK',
                            )
                    ));
//                ->add('pageName')
//                ->add('connexion')
//                ->add('enableDisplay')
//                ->add('dateCreate')
//                ->add('dateModify')
//                ->add('createdBy')
//                ->add('modifiedBy');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CRM\ToolsBundle\Entity\CrmQueries'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'crm_toolsbundle_crmqueries';
    }


}
