<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\ProcessBuilder;

class DataQualityController extends Controller
{

    public function errorsAnalysisAction(){
        $end_date = new \DateTime();
        $start_date = new \DateTime();
        $start_date->modify('-10 day');

        $date_array = array();
        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $groupsName = $em->getRepository('CRMToolsBundle:CrmQueries')->getGroupsName();

        $dataQualities = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->getDataQualityTable($groupsName, $date_array);

        return $this->render('CRMToolsBundle:DataQuality:errorsAnalysis.html.twig',array(
            'dataQualities' => $dataQualities,
            'groupsName'   => $groupsName,
            'date_array'    => $date_array
        ));
    }

    public function reloadRequestAction($query_id){

        $current_date  = new \DateTime();
        $current_date = $current_date->format('Y-m-d');

        $em = $this->getDoctrine()->getManager();
        $currentQuery = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->getOneQueryWithId($query_id, $current_date);

        if(isset($currentQuery[0]['queryText'])){
            $em = $this->getDoctrine()->getManager('oracle_Q5');
            $queryResult = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->executeQueryWithId($currentQuery);
        }

        if(isset($queryResult)) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('CRMToolsBundle:CrmQueriesResult')->insertResultQuery($currentQuery, $queryResult, $current_date);
        }

        return $this->redirect( $this->generateUrl('crm_errors_analysis'));

    }

}
