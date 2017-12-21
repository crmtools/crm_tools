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
//            $checkQueryTime = $this->get('check_query_time')->test($env, $queryText);

            try{
                $em = $this->getDoctrine()->getManager($current_bdd.$env);
                $query = $em->getConnection()->prepare($queryText);
//                $query->setTimeout(3600);
                $query->execute();

//                var_dump($query);die;
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

    public function indicatorsModificationSuppresionAction(Request $request){

        /*Creat the form without a formType*/
        $crmQueries = new CrmQueries();
        $form = $this->createFormIndicators($crmQueries);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();
            $searchText = $form->get("searchText")->getData();
            var_dump($searchText);die;
        }

        return $this->render('CRMToolsBundle:ToolBox:indicatorsModificationSuppresion.html.twig', array(
            'form' => $form->createView(),
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

}
