<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CRM\ToolsBundle\Entity\CrmQueriesUcr;
use Symfony\Component\HttpFoundation\Request;

class UcrSearchEngineController extends Controller
{
    public function contactFormAction(Request $request){

        /*Creat the form without a formType*/
        $crmQueriesUcr = new CrmQueriesUcr();
        $form = $this->creatFormContactForm($crmQueriesUcr);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            if($form->get("searchBy")->getData()){
                $searchBy = $form->get("searchBy")->getData();
            }

            if($form->get("searchText")->getData()){
                $searchText = $form->get("searchText")->getData();
            }

            if($form->get("environment")->getData()){
                $env = $form->get("environment")->getData();
            }

            $tmp_id = null;
            $search_values_array= array();
            if(isset($searchBy)  && isset($searchText)  && isset($env)){
                $array = preg_split( '/[\s,]+/',trim($searchText));

                foreach ($array as $value){
                    if (intval($value) != 0) {
                        $search_values_array[] .= $value;
                    } elseif(strpos($value, '@')) {
                        $search_values_array[] .= $value;
                    }else{
                        $search_values_array[] .= null;
                    }
                }

                foreach($search_values_array as $current_value) {
                    if($current_value != null){
                        if ($searchBy == 'EMAIL' || strpos($searchText, '@')) {
                            $tmp_id .= ",lower(trim('" . trim($current_value) . "'))";
                        } else if ($searchBy == 'POLO' || $searchBy == 'LEXO' || $searchBy == 'MIDAS' || $searchBy == 'BBOSS') {
                            $tmp_id .= ",'" . trim($current_value) . "'";
                        } else {
                            $tmp_id .= "," . trim($current_value) . "";
                        }
                    }
                }

                if($tmp_id){
                    $tmp_id = substr($tmp_id,1); // remove initial ","

                    if($searchBy == 'EMAIL' || strpos( $searchText , '@'))
                    {
                        $query = "select id_contact from cli_email where lower(trim(email)) in ($tmp_id)";
                    }
                    else if ($searchBy == 'POLO' || $searchBy == 'LEXO' || $searchBy == 'MIDAS' || $searchBy == 'BBOSS')
                    {
                        $query = "select id_contact from cli_refext where code_appli = '$searchBy' and id_refext in ($tmp_id)";
                    }
                    else
                    {
                        $query = "select id_contact from cli_contact where id_contact in ($tmp_id)";
                    }

                    if($query){
                        try{
                            $em = $this->getDoctrine()->getManager('oracle_'.$env);
                            $contact_ids = $em->getRepository('CRMToolsBundle:ClassUcr')->getIdsContact($query);
                        }catch(\Exception $e){
                            $error_message= $e->getMessage();
                            return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig', array(
                                'form' => $form->createView(),
                                'error_message'    => $error_message
                            ));
                        }

                        if($contact_ids){
                            $em = $this->getDoctrine()->getManager();
                            $crm_queries_contact = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getUcrQueriesContact();

                            $queries_contact_modify= array();
                            foreach ($crm_queries_contact as $key => $result){
                                $queries_contact_modify[$key]['queryName'] =  $result['queryName'];
                                $queries_contact_modify[$key]['queryText'] = str_replace('= 1','in (' . $contact_ids . ')' ,$result['queryText']);
                            }


                            $em = $this->getDoctrine()->getManager('oracle_'.$env);
                            $queries_ucr_result = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getResultUcrQueries($queries_contact_modify);
                        }else{
                            return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig', array(
                                'form' => $form->createView()
                            ));
                        }
                    }
                    return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig', array(
                        'queries_ucr_result' => $queries_ucr_result,
                        'form' => $form->createView()
                    ));
                }
            }
        }
        return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function bookingFormAction(Request $request){

        /*Creat the form without a formType*/
        $crmQueriesUcr = new CrmQueriesUcr();
        $form = $this->creatFormBookingForm($crmQueriesUcr);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            if($form->get("searchBy")->getData()){
                $searchBy = $form->get("searchBy")->getData();
            }

            if($form->get("searchText")->getData()){
                $searchText = $form->get("searchText")->getData();
            }
            if($form->get("environment")->getData()){
                $env = $form->get("environment")->getData();
            }

            $tmp_id = null;
            if (isset($searchBy) && isset($searchText) && isset($env)) {

                $array_ids = preg_split('/[\s,]+/', trim($searchText));

                foreach ($array_ids as $current_id) {
                    $current_id = intval($current_id);
                    if ($current_id != 0) {
                        $tmp_id .= "," . trim($current_id) . "";
                    } else {
                        $tmp_id .= null;
                    }
                }

                if($tmp_id != null){
                    $tmp_id = substr($tmp_id, 1); // remove initial ","
                    if($searchBy == 'ID_HEADER') {
                        $booking_ids = $tmp_id;
                    }else{
                        $query = "select id_header from sta_header where code_appli = '$searchBy' and id_source in ($tmp_id)";
                        $em = $this->getDoctrine()->getManager('oracle_'.$env);
                        $booking_ids = $em->getRepository('CRMToolsBundle:ClassUcr')->getIdsContact($query);
                    }

                    if ($booking_ids){
                        $em = $this->getDoctrine()->getManager();
                        $crm_queries_booking = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getUcrQueriesBooking();

                        $queries_booking_modify = array();
                        foreach ($crm_queries_booking as $key => $result) {
                            $queries_contact_modify[$key]['queryName'] = $result['queryName'];
                            $queries_contact_modify[$key]['queryText'] = str_replace('= 1', 'in (' . $booking_ids . ')', $result['queryText']);
                        }

                        try{
                            $em = $this->getDoctrine()->getManager('oracle_' . $env);
                            $queries_ucr_result = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getResultUcrQueries($queries_contact_modify);
                        }catch(\Exception $e){
                            $error_message= $e->getMessage();
                            return $this->render('CRMToolsBundle:UcrSearchEngine:bookingForm.html.twig', array(
                                'form' => $form->createView(),
                                'error_message'    => $error_message
                            ));
                        }

                    }
                    if (isset($queries_ucr_result)){
                        return $this->render('CRMToolsBundle:UcrSearchEngine:bookingForm.html.twig', array(
                            'queries_ucr_result' => $queries_ucr_result,
                            'form'               => $form->createView(),
                        ));
                    }
                }
            }
        }

        return $this->render('CRMToolsBundle:UcrSearchEngine:bookingForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function creatFormContactForm($crmQueriesUcr){
        $form = $this->createFormBuilder($crmQueriesUcr)
            ->add('searchBy', 'choice', array(
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
            ->add('environment', 'choice', array(
                'mapped'    => false,
                'expanded'  => true,
                'multiple'  => false,
                'choices'   => array(
                    'Q3' => 'Q3',
                    'Q4' => 'Q4',
                    'Q5' => 'Q5',
                    'P1' => 'P1',
                )
            ))
            ->getForm();

        return $form;
    }

    public function creatFormBookingForm($crmQueriesUcr){
        $form = $this->createFormBuilder($crmQueriesUcr)
            ->add('searchBy', 'choice', array(
                'mapped'    => false,
                'label'     => 'Search By :',
                'choices'   => array(
                    'ID_HEADER' => 'ID_HEADER',
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
            ->add('environment', 'choice', array(
                'mapped'    => false,
                'expanded'  => true,
                'multiple'  => false,
                'choices'   => array(
                    'Q3' => 'Q3',
                    'Q4' => 'Q4',
                    'Q5' => 'Q5',
                    'P1' => 'P1',
                )
            ))
            ->getForm();

        return $form;
    }
}
