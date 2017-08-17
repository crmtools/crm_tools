<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Entity\ClassUcr;
use CRM\ToolsBundle\Form\ClassUcrType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CrmWeatherController extends Controller
{
    public function totalCompaignsAction(){

        $nbr= 3;
        $em = $this->getDoctrine()->getManager();
        $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
        $queryName = $queryContent['queryName'];

        $em = $this->getDoctrine()->getManager('oracle_Q5');
        $queryResult =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResulTotalCompaigns($queryContent);

        return $this->render('CRMToolsBundle:CrmWeather:totalCompaigns.html.twig', array(
            'queryName' => $queryName,
            'queryResult' => $queryResult
        ));
    }

    public function  contactCreationAction(Request $request){

        $end_date = new \DateTime();
        $end_date = $end_date->format('d-m-Y');

        $start_date = new \DateTime();
        $start_date->modify('-35 day');
        $start_date = $start_date->format('d-m-Y');

        /*Creat the form*/
        $classUcr = new ClassUcr();
        $form = $this->createForm (ClassUcrType::class, $classUcr);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $start_date  = $form->get("startDate")->getData();
            $start_date = $start_date->format('d-m-Y');

            $end_date = $form->get("endDate")->getData();
            $end_date = $end_date->format('d-m-Y');

            if($start_date > $end_date){
                return $this->redirect( $this->generateUrl('crm_retargeting_monitoring'));
            }else{
                $nbr= 0;
                $em = $this->getDoctrine()->getManager();
                $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
                $queryName = $queryContent['queryName'];
                $em = $this->getDoctrine()->getManager('oracle_prod');
                $queryResult    =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent, $start_date, $end_date);
                $column_names   = $queryResult[0];
                $array_content  = $queryResult[1];
            }
        }else{
            $nbr= 0;
            $em = $this->getDoctrine()->getManager();
            $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
            $queryName = $queryContent['queryName'];

            $em = $this->getDoctrine()->getManager('oracle_prod');
            $queryResult =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent);
            $column_names   = $queryResult[0];
            $array_content  = $queryResult[1];
        }

        return $this->render('CRMToolsBundle:CrmWeather:contactCreation.html.twig', array(
            'form'            => $form->createView(),
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'queryName'       => $queryName,
            'column_names'    => $column_names,
            'array_content'   => $array_content
        ));
    }

    public function retargetingMonitoringAction(Request $request){

        $end_date = new \DateTime();
        $end_date = $end_date->format('d-m-Y');

        $start_date = new \DateTime();
        $start_date->modify('-15 day');
        $start_date = $start_date->format('d-m-Y');

        /*Creat the form*/
        $classUcr = new ClassUcr();
        $form = $this->createForm (ClassUcrType::class, $classUcr);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $start_date  = $form->get("startDate")->getData();
            $start_date = $start_date->format('d-m-Y');

            $end_date = $form->get("endDate")->getData();
            $end_date = $end_date->format('d-m-Y');

            if($start_date > $end_date){
                return $this->redirect($this->generateUrl('crm_retargeting_monitoring'));
            }else{
                $nbr= 1;
                $em = $this->getDoctrine()->getManager();
                $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
                $queryName = $queryContent['queryName'];
                $em = $this->getDoctrine()->getManager('oracle_prod');
                $queryResult    =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent, $start_date, $end_date);
                $column_names   = $queryResult[0];
                $array_content  = $queryResult[1];
            }
        }else{
            $nbr= 1;
            $em = $this->getDoctrine()->getManager();
            $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
            $queryName = $queryContent['queryName'];

            $em = $this->getDoctrine()->getManager('oracle_prod');
            $queryResult    =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent);
            $column_names   = $queryResult[0];
            $array_content  = $queryResult[1];
        }

        return $this->render('CRMToolsBundle:CrmWeather:retargetingMonitoring.html.twig', array(
            'form'            => $form->createView(),
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'queryName'       => $queryName,
            'column_names'    => $column_names,
            'array_content'   => $array_content
        ));
    }

    public function gameIntegrationAction(Request $request){

        $end_date = new \DateTime();
        $end_date = $end_date->format('d-m-Y');

        $start_date = new \DateTime();
        $start_date->modify('-35 day');
        $start_date = $start_date->format('d-m-Y');

        /*Creat the form*/
        $classUcr = new ClassUcr();
        $form = $this->createForm (ClassUcrType::class, $classUcr);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $start_date  = $form->get("startDate")->getData();
            $start_date = $start_date->format('d-m-Y');

            $end_date = $form->get("endDate")->getData();
            $end_date = $end_date->format('d-m-Y');

            if($start_date > $end_date){
                return $this->redirect($this->generateUrl('crm_retargeting_monitoring'));
            }else{
                $nbr= 2;
                $em = $this->getDoctrine()->getManager();
                $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
                $queryName = $queryContent['queryName'];
                $em = $this->getDoctrine()->getManager('oracle_prod');
                $queryResult    =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent, $start_date, $end_date);
                $column_names   = $queryResult[0];
                $array_content  = $queryResult[1];
            }
        }else{
            $nbr= 2;
            $em = $this->getDoctrine()->getManager();
            $queryContent = $em->getRepository('CRMToolsBundle:CrmQueries')->getQueryFromCrmWheather($nbr);
            $queryName = $queryContent['queryName'];

            $em = $this->getDoctrine()->getManager('oracle_prod');
            $queryResult    =  $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResult($queryContent);
            $column_names   = $queryResult[0];
            $array_content  = $queryResult[1];
        }

        return $this->render('CRMToolsBundle:CrmWeather:gameIntegration.html.twig', array(
            'form'            => $form->createView(),
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'queryName'       => $queryName,
            'column_names'    => $column_names,
            'array_content'   => $array_content
        ));
    }


}

