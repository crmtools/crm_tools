<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\ProcessBuilder;

class DataQualityController extends Controller
{

    public function ucrErrorsAnalysisAction(){

        $database= 'UCR';
        $end_date = new \DateTime();
        $start_date = new \DateTime();
        $start_date->modify('-10 day');

        $date_array = array();
        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $groupsName = $em->getRepository('CRMToolsBundle:CrmQueries')->getGroupsNameUcr();
        $dataQualities = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->getDataQualityTable($groupsName, $database, $date_array);

        return $this->render('CRMToolsBundle:DataQuality:ucrErrorsAnalysis.html.twig',array(
            'dataQualities' => $dataQualities,
            'groupsName'   => $groupsName,
            'date_array'    => $date_array
        ));
    }

    public function pickErrorsAnalysisAction(){

        $database= 'PICK';
        $end_date = new \DateTime();
        $start_date = new \DateTime();
        $start_date->modify('-10 day');

        $date_array = array();
        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $groupsName = $em->getRepository('CRMToolsBundle:CrmQueries')->getGroupsNamePick();

        if(isset($groupsName)){
        $dataQualities = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->getDataQualityTable($groupsName, $database, $date_array);
        }

        return $this->render('CRMToolsBundle:DataQuality:pickErrorsAnalysis.html.twig',array(
            'dataQualities' => $dataQualities,
            'groupsName'   => $groupsName,
            'date_array'    => $date_array
        ));
    }

    public function reloadRequestAction($query_id){

        $current_date  = new \DateTime();
        $current_date = $current_date->format('Y-m-d');

        $this->get('refresh_button_analysis')->refreshButtonWithId($query_id, $current_date);

        return $this->redirect( $this->generateUrl('crm_errors_analysis'));
    }


}
