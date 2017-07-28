<?php

namespace CRM\ToolsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class LogsViewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $end_date = new \DateTime();
        $end_date= $end_date->format('d-m-Y');

        $start_date = new \DateTime();
        $start_date->modify('-7 day');
        $start_date= $start_date->format('d-m-Y');

//        $builder->add('startDate', DateType::class, array(    // avec DateType::class
        $builder->add('startDate', 'date', array(
                    'label'     =>'Start date',
                    'widget'    => 'single_text',
                    'format'    => 'dd-MM-yyyy',
                    'html5'     => false,
                    'attr'      => ['class'         => 'form-control js-datepicker',
                                      'id'          => 'date',
                                      'name'        => 'date',
                                      'placeholder' => $start_date]
                ))
                ->add('endDate', 'date', array(
                    'label'     => 'End date',
                    'widget'    => 'single_text',
                    'html5'     => false,
                    'format'    => 'dd-MM-yyyy',
                    'attr'      => ['class'         => 'form-control js-datepicker',
                                      'id'          => 'date',
                                      'name'        => 'date',
                                      'placeholder' => $end_date]
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CRM\ToolsBundle\Entity\LogsView'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'crm_toolsbundle_logsview';
    }


}
