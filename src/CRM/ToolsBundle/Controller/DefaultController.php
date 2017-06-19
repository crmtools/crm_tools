<?php

namespace CRM\ToolsBundle\Controller;


use CRM\ToolsBundle\Entity\LogsView;
use CRM\ToolsBundle\Form\LogsViewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMToolsBundle:Default:homepage.html.twig');
    }

    public function logsViewAction()
    {

//        $em = $this->getDoctrine()->getManager();
//        $test= $em->getRepository("CRMToolsBundle:LogsView")->findAll();
//        var_dump($test);die;

        $end_date_array = new \DateTime();

        $start_date_array = new \DateTime();
        $start_date_array->modify('-7 day');

        $start_date= $start_date_array->format('Y-m-d');
        $end_date= $end_date_array->format('Y-m-d');

        $date_array= array();
        while($start_date_array<=$end_date_array){
            array_push($date_array,$start_date_array->format('Y-m-d'));
            $start_date_array->modify('+1 day');
        }

        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayGraphTable($start_date, $end_date, $date_array);
        var_dump($result);die;


        return new Response('test');
    }
}


