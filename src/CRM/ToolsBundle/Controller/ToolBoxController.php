<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\CrmQueries;
use CRM\ToolsBundle\Form\CrmQueriesType;

class ToolBoxController extends Controller
{
    public function creatingUcrQueryAction(Request $request){

        /*Creat the form*/
        $crmQueries = new CrmQueries();
        $form = $this->createForm (new CrmQueriesType(), $crmQueries);
        $error_message= null;

        if($request->isMethod('POST')) {

            $form->handleRequest($request);
            $data = $form->getData();

            $database = $form->get("database")->getData();

            $queryText = $data->getQueryText();
            $database_user = $this->container->getParameter('database_user');

            if ($database_user == 'crm-dev') {
                $env = 'Q5';
            } else {
                $env = 'P1';
            }

//            $checkQueryTime = $this->get('check_query_time')->run($env, $queryText);
//
//            var_dump($checkQueryTime);die;

            try{
                $em = $this->getDoctrine()->getManager('oracle_'.$env);
                $query = $em->getConnection()->prepare($queryText);
//                $query->setTimeout(3600);
                $query->execute();

//                var_dump($query);die;
            }catch(\Exception $e){
                $error_message= $e->getMessage();
            }

            if(!isset($error_message)){
                $em = $this->getDoctrine()->getManager('oracle_' . $env);
                $result_query = $em->getRepository('CRMToolsBundle:ClassUcr')->getResultForTheNewQuery($queryText);

                $queryText= str_replace("'","\"", $queryText);

                if($result_query == false){
                    $error_message= 'The query should be return a number with: COUNT, MAX and MIN';
                }else{
                    $user= $this->getUser();
                    $em = $this->getDoctrine()->getManager();
                    $is_insert = $em->getRepository('CRMToolsBundle:CrmQueries')->insertTheNewQueryIntoCrmQueries($queryText, $data, $database, $user, $env);

                    if($is_insert){
                        $queryName = $data->getQueryName();
                        $em = $this->getDoctrine()->getManager();
                        $newQuery = $em->getRepository('CRMToolsBundle:CrmQueries')->getNewQuery($queryName);

                        $is_insert_result = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->insertResultInCrmQueriesResult($newQuery, $result_query);

                        if($is_insert_result){
                            $success_message= "Query successfully created. Results are visible in Dataquality Errors' analysis module";

                            return $this->render('CRMToolsBundle:ToolBox:creatingUcrQuery.html.twig',array(
                                'form'          => $form->createView(),
                                'success_message' => $success_message
                            ));
                        }else{
                            $error_message= 'the result must be a number ';
                        }

                    }else{
                        $error_message= 'A query with a similar name already exists in the CRM Tool database. Please rename your query';
                    }
                }
            }
        }

        return $this->render('CRMToolsBundle:ToolBox:creatingUcrQuery.html.twig',array(
            'form'          => $form->createView(),
            'error_message' => $error_message
        ));
    }

}
