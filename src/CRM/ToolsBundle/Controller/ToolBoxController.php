<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\CrmQueries;
use CRM\ToolsBundle\Form\CrmQueriesType;

class ToolBoxController extends Controller
{
    public function indicatorsCreationAction(Request $request){

        /*Creat the form*/
        $crmQueries = new CrmQueries();
        $form = $this->createForm (new CrmQueriesType(), $crmQueries);
        $error_message= null;

        if($request->isMethod('POST')){

            $form->handleRequest($request);
            $data = $form->getData();
            $database = $form->get("database")->getData();

            if($database == 'UCR') {
                $groupName= $form->get("groupNameUcr")->getData();
            }else{
                $groupName= $form->get("groupNamePick")->getData();
            }

            $queryText = $data->getQueryText();
            $database_user = $this->container->getParameter('database_user');

            if ($database_user == 'crm-dev') {
                $env = 'Q5';
            } else {
                $env = 'P1';
            }

            if($database=='UCR'){
                $current_bdd= 'oracle_';
            }else{
                $current_bdd= 'pick_';
            }

            try{
                $em = $this->getDoctrine()->getManager($current_bdd.$env);
                $query = $em->getConnection()->prepare($queryText);
                $query->execute();

            }catch(\Exception $e){
                $error_message= $e->getMessage();
            }

            if(!isset($error_message)){
                $em = $this->getDoctrine()->getManager($current_bdd. $env);
                $result_query = $em->getRepository('CRMToolsBundle:ClassUcr')->getResultForTheNewQuery($queryText);
                $queryText= str_replace("'","\'", $queryText);
                if($result_query == false){
                    $error_message= 'The query should be return a number with: COUNT, MAX and MIN';
                }else{
                    $user= $this->getUser();
                    $em = $this->getDoctrine()->getManager();
                    $is_insert = $em->getRepository('CRMToolsBundle:CrmQueries')->insertTheNewQueryIntoCrmQueries($queryText, $data, $groupName, $database, $user, $env);

                    if($is_insert){
                        $queryName = $data->getQueryName();
                        $em = $this->getDoctrine()->getManager();
                        $newQuery = $em->getRepository('CRMToolsBundle:CrmQueries')->getNewQuery($queryName);

                        $is_insert_result = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->insertResultInCrmQueriesResult($newQuery, $result_query);

                        if($is_insert_result){
                            if($database== 'UCR'){
                                $success_message= "Query successfully created. Results are visible in Dataquality / UCR Errors' analysis module";
                            }else{
                                $success_message= "Query successfully created. Results are visible in Dataquality / PICK Errors' analysis module";
                            }

                            return $this->render('CRMToolsBundle:ToolBox:indicatorsCreation.html.twig',array(
                                'form'          => $form->createView(),
                                'success_message' => $success_message
                            ));
                        }

                    }else{
                        $error_message= 'A query with a similar name already exists in the CRM Tool database. Please rename your query';
                    }
                }
            }
        }

        return $this->render('CRMToolsBundle:ToolBox:indicatorsCreation.html.twig',array(
            'form'          => $form->createView(),
            'error_message' => $error_message
        ));
    }

    public function indicatorsModificationSuppressionAction(Request $request){

        /*Creat the form without a formType*/
        $crmQueries = new CrmQueries();
        $form = $this->createFormIndicators($crmQueries);
        $user_id= $this->getUser()->getId();

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $data = $form->getData();
            $searchText = $form->get("searchText")->getData();

            $array_search_text = explode( ',',trim($searchText));

            $em = $this->getDoctrine()->getManager();
            $results_query = $em->getRepository('CRMToolsBundle:CrmQueries')->getResultWithSearchText($array_search_text);

            if($results_query){
                return $this->render('CRMToolsBundle:ToolBox:indicatorsModificationSuppression.html.twig', array(
                    'form'          => $form->createView(),
                    'results_query' => $results_query,
                    'current_user_id'    => $user_id,
                ));
            }
        }

        return $this->render('CRMToolsBundle:ToolBox:indicatorsModificationSuppression.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function indicatorModificationAction(Request $request, $result_id){

        $error_message= null;
        /*Creat the form*/
        $crmQueries = new CrmQueries();
        $form = $this->createForm (new CrmQueriesType(), $crmQueries);

        $em = $this->getDoctrine()->getManager();
        $sql= "SELECT * FROM  crm_queries where id= $result_id";
        $query = $em->getConnection()->prepare($sql);
        $query->execute();

        $current_indicator = $query->fetchAll();

        if($request->isMethod('POST')){

            $form->handleRequest($request);
            $data = $form->getData();
            $database = $form->get("database")->getData();

            $queryName= $data->getQueryName();

            if($database == 'UCR') {
                $groupName= $form->get("groupNameUcr")->getData();
            }else{
                $groupName= $form->get("groupNamePick")->getData();
            }

            $queryText = $data->getQueryText();
            $database_user = $this->container->getParameter('database_user');

            if ($database_user == 'crm-dev') {
                $env = 'Q5';
            } else {
                $env = 'P1';
            }

            if($database=='UCR'){
                $current_bdd= 'oracle_';
            }else{
                $current_bdd= 'pick_';
            }

            try{
                $em = $this->getDoctrine()->getManager($current_bdd.$env);
                $query = $em->getConnection()->prepare($queryText);
                $query->execute();

            }catch(\Exception $e){
                $error_message= $e->getMessage();
            }

            if(!isset($error_message)){
                $em = $this->getDoctrine()->getManager($current_bdd. $env);
                $result_query = $em->getRepository('CRMToolsBundle:ClassUcr')->getResultForTheNewQuery($queryText);
                $queryText= str_replace("'","\'", $queryText);
                if($result_query == false){
                    $error_message= 'The query should be return a number with: COUNT, MAX and MIN';
                }else{
                    $user= $this->getUser();
                    $em = $this->getDoctrine()->getManager();
                    $is_modify = $em->getRepository('CRMToolsBundle:CrmQueries')->modifyQueryIntoCrmQueries($queryText, $data, $groupName, $database, $user, $env, $result_id);

                    if($is_modify){
                        $queryName = $data->getQueryName();

                        $em = $this->getDoctrine()->getManager();
                        $newQuery = $em->getRepository('CRMToolsBundle:CrmQueries')->getNewQuery($queryName);

                        $is_insert_result = $em->getRepository('CRMToolsBundle:CrmQueriesResult')->insertResultFromModifiedQuery($newQuery, $result_query, $result_id);

                        if($is_insert_result){
                            if($database== 'UCR'){
                                $success_message= "Query successfully modified. Results are visible in Dataquality / UCR Errors' analysis module";
                            }else{
                                $success_message= "Query successfully modified. Results are visible in Dataquality / PICK Errors' analysis module";
                            }

                            /*Creat the form without a formType*/
                            $crmQueries = new CrmQueries();
                            $form = $this->createFormIndicators($crmQueries);

                            return $this->render('CRMToolsBundle:ToolBox:indicatorsModificationSuppression.html.twig',array(
                                'form'            => $form->createView(),
                                'success_message' => $success_message,
                            ));
                        }
                    }
                }
            }
        }

        return $this->render('CRMToolsBundle:ToolBox:indicatorModification.html.twig', array(
            'form'               => $form->createView(),
            'current_indicator'  => $current_indicator,
            'error_message'      => $error_message
        ));
    }

    public function createFormIndicators($crmQueriesUcr){
        $form = $this->createFormBuilder($crmQueriesUcr)
            ->add('searchText', 'text', array(
                'mapped'    => false,
                'label'     => 'Query name search :',
                'required'    => true,
            ))
            ->getForm();

        return $form;
    }

    public function indicatorSuppressionAction($query_id){

        /*Creat the form*/
        $crmQueries = new CrmQueries();
        $form = $this->createFormIndicators($crmQueries);

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('CRMToolsBundle:CrmQueriesResult')->supprResultInCrmQueriesResult($query_id);

        $em->getRepository('CRMToolsBundle:CrmQueries')->supprQueryInCrmQueries($query_id);

        $success_message= "The Query is successfully deleted from crm_queries table";

        return $this->render('CRMToolsBundle:ToolBox:indicatorsModificationSuppression.html.twig', array(
            'form'            => $form->createView(),
            'success_message' => $success_message
        ));

    }



}
