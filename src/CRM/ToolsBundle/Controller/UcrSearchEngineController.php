<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Entity\CrmQueriesUcr;
use CRM\ToolsBundle\Form\CrmQueriesUcrType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UcrSearchEngineController extends Controller
{
    public function contactFormAction(Request $request){

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
            $search_values_array= array();
            if(isset($search_type)  && isset($id_field)  && isset($env)){
                $array = preg_split( '/[\s,]+/',trim($id_field));

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
                        if ($search_type == 'EMAIL' || strpos($id_field, '@')) {
                            $tmp_id .= ",lower(trim('" . trim($current_value) . "'))";
                        } else if ($search_type == 'POLO' || $search_type == 'LEXO' || $search_type == 'MIDAS' || $search_type == 'BBOSS') {
                            $tmp_id .= ",'" . trim($current_value) . "'";
                        } else {
                            $tmp_id .= "," . trim($current_value) . "";
                        }
                    }
                }

                if($tmp_id){
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
                        $contact_ids = $em->getRepository('CRMToolsBundle:ClassUcr')->getIdsContact($query);

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
                            return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig');
                        }
                    }

                    return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig', array(
                        'queries_ucr_result' => $queries_ucr_result
                    ));
                }
            }
        }

        return $this->render('CRMToolsBundle:UcrSearchEngine:contactForm.html.twig');
    }

    public function bookingFormAction(Request $request){

        if($request->isMethod('POST')) {

            if (isset($_POST['search_type'])) {
                $search_type = $_POST['search_type'];
            }
            if (isset($_POST['id_field']) && $_POST['id_field'] != '') {
                $id_field = $_POST['id_field'];

            }
            if (isset($_POST['env'])) {
                $env = $_POST['env'];
            }

            $tmp_id = null;
            if (isset($search_type) && isset($id_field) && isset($env)) {

                $array_ids = preg_split('/[\s,]+/', trim($id_field));

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
                    if($search_type == 'ID_HEADER') {
                        $booking_ids = $tmp_id;
                    }else{
                        $query = "select id_header from sta_header where code_appli = '$search_type' and id_source in ($tmp_id)";
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

                    $em = $this->getDoctrine()->getManager('oracle_' . $env);
                    $queries_ucr_result = $em->getRepository('CRMToolsBundle:CrmQueriesUcr')->getResultUcrQueries($queries_contact_modify);
                    }
                    if (isset($queries_ucr_result)){
                        return $this->render('CRMToolsBundle:UcrSearchEngine:bookingForm.html.twig', array(
                            'queries_ucr_result' => $queries_ucr_result
                        ));
                    }
                }
            }
        }

        return $this->render('CRMToolsBundle:UcrSearchEngine:bookingForm.html.twig');
    }
}
