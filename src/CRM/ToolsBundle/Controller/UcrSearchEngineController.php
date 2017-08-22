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
           $search_type = $_POST['search_type'];
            $id_field = $_POST['id_field'];
            $env = $_POST['env'];
            $tmp_id = null;
            if($search_type != NULL && $id_field != NULL && $env != NULL){
//                var_dump('les données sont:'.$search_type.' '.$id_field.' '.$env);
                $array = preg_split( '/[\s,]+/',trim($id_field));

                foreach($array as $current_id) {
                    if ($search_type == 'EMAIL' || strpos($id_field, '@')) {
                        $tmp_id .= ",lower(trim('" . trim($current_id) . "'))";
                        $query = "select id_contact from cli_email where lower(trim(email)) in ($tmp_id)";
                    } else if ($search_type == 'POLO' || $search_type == 'LEXO' || $search_type == 'MIDAS' || $search_type == 'BBOSS') {
                        $tmp_id .= ",'" . trim($current_id) . "'";
                        $query = "select id_contact from cli_refext where code_appli = '$search_type' and id_refext in ($tmp_id)";
                    } else {
                        $tmp_id .= "," . trim($current_id) . "";
                        $query = "select id_contact from cli_contact where id_contact in ($tmp_id)";
                    }
                }
                var_dump($tmp_id);die;

            }
        }

        return $this->render('CRMToolsBundle:UcrSearchEngine:contactBookingForms.html.twig');
    }
}
