<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Entity\CrmQueriesUcr;
use CRM\ToolsBundle\Form\CrmQueriesUcrType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UcrSearchEngineController extends Controller
{
    public function contactBookingFormsAction(Request $request){

        if($request->isMethod('POST')){
            if(isset($_POST['search_type'])){
                $search_type = $_POST['search_type'];
            }
            if(isset($_POST['id_field']) && $_POST['id_field'] != ''){
                $id_field = $_POST['id_field'];
            }
            if(isset($_POST['env'])){
                $env = $_POST['env'];
            }

            $tmp_id = null;
            if(isset($search_type)  && isset($id_field)  && isset($env)){
                $array = preg_split( '/[\s,]+/',trim($id_field));

                foreach($array as $current_id) {
                    if ($search_type == 'EMAIL' || strpos($id_field, '@')) {
                        $tmp_id .= ",lower(trim('" . trim($current_id) . "'))";
                    } else if ($search_type == 'POLO' || $search_type == 'LEXO' || $search_type == 'MIDAS' || $search_type == 'BBOSS') {
                        $tmp_id .= ",'" . trim($current_id) . "'";
                    } else {
                        $tmp_id .= "," . trim($current_id) . "";
                    }
                }

                $tmp_id = substr($tmp_id,1); // remove initial ","

                if($search_type == 'EMAIL' || strpos( $id_field , '@'))
                {
                    $query = "select id_contact from cli_email where lower(trim(email)) in ($tmp_id)";
                }
                else if ($search_type == 'POLO' || $search_type == 'LEXO' || $search_type == 'MIDAS' || $search_type == 'BBOSS')
                {
                    $query = "select id_contact from cli_refext where code_appli = '$search_type' and id_refext in ($tmp_id)";
                }
                else
                {
                    $query = "select id_contact from cli_contact where id_contact in ($tmp_id)";
                }

                if($query){
                    $em = $this->getDoctrine()->getManager('oracle_'.$env);
                    $contact_ids = $em->getRepository('CRMToolsBundle:ClassUcr')->getQueryResultSearch($query);

                    if($contact_ids){
                        $em = $this->getDoctrine()->getManager();
                        $crm_queries_ucr = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getUcrQueries();

                        $queries_ucr_modify= array();

                        foreach ($crm_queries_ucr as $key => $result){
                            $queries_ucr_modify[$key]['queryName'] =  $result['queryName'];
                            $queries_ucr_modify[$key]['queryText'] = str_replace('= 1','in (' . $contact_ids . ')' ,$result['queryText']);
                        }

                        $em = $this->getDoctrine()->getManager('oracle_'.$env);
                        $queries_ucr_result = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getResultUcrQueries($queries_ucr_modify);
                    }else{
                        return $this->render('CRMToolsBundle:UcrSearchEngine:contactBookingForms.html.twig');
                    }
                }

                return $this->render('CRMToolsBundle:UcrSearchEngine:contactBookingForms.html.twig', array(
                    'queries_ucr_result' => $queries_ucr_result
                ));
            }
        }

        return $this->render('CRMToolsBundle:UcrSearchEngine:contactBookingForms.html.twig');
    }
}
