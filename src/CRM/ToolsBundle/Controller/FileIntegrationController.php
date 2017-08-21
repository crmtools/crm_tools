<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Service\getEntityManager;
use Doctrine\DBAL\VersionAwarePlatformDriver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\CrmImportFile;
use CRM\ToolsBundle\Form\CrmImportFileType;
use CRM\ToolsBundle\Service\checkFile;
use CRM\ToolsBundle\Entity\CLI_DATA_IMPORTS;
use CRM\ToolsBundle\Form\CLI_DATA_IMPORTSType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileIntegrationController extends Controller
{
    public function fileUploadAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $displayFilesImport = $em->getRepository('CRMToolsBundle:CrmImportFile')->getFilesImporToDisplay();
        $currentHostname = $this->get('utility_class')->getUserHostname();

        $user_id_array = $em->getRepository('CRMToolsBundle:CrmUsers')->getUserId($currentHostname);
        $user_id= $user_id_array[0]['id'];

        $currentUser = $em->getRepository('CRMToolsBundle:CrmUsers')->getCurrentUser($currentHostname);
        $crmImportFile = new crmImportFile();
        $form = $this->createForm(new CrmImportFileType(), $crmImportFile);
        $form->handleRequest($request);

        if ($request->isMethod('POST')){
            $data = $form->getData();
            $file_name = $data->getFileName()->getClientOriginalName();
            $tmp_file = $data->getFileName()->getPathName();

            $tmp_path_dir = $this->container->getParameter('CRMToolsBundle.tmp_files_directory');
            $tmp_path_dir = $_SERVER['DOCUMENT_ROOT']. $tmp_path_dir;

            $upload_path_dir = $this->container->getParameter('CRMToolsBundle.uploaded_files_directory');
            $upload_path_dir = $_SERVER['DOCUMENT_ROOT']. $upload_path_dir;

            $file_import = $em->getRepository('CRMToolsBundle:CrmImportFile')->getFileImport($file_name);

            $check_file_array = $this->get('check_file_class')->check_file_uploaded($tmp_file, $tmp_path_dir.$file_name, $file_name, $currentHostname, $file_import, $em, $user_id, $tmp_path_dir, $upload_path_dir);

            if(isset($check_file_array['error_message'])){
                $error_message = $check_file_array['error_message'];

                return $this->render('CRMToolsBundle:FileIntegration:fileUpload.html.twig', array(
                    'displayFilesImport' => $displayFilesImport,
                    'currentUser'        => $currentUser,
                    'form'               => $form->createView(),
                    'error_message'       => $error_message
                ));
            }else{
                $config = $check_file_array['config'];
                $errors_array = $check_file_array['errors_array'];
                $nb_lines = $check_file_array['nb_lines'];

                return $this->render('CRMToolsBundle:FileIntegration:fileUpload.html.twig', array(
                    'displayFilesImport' => $displayFilesImport,
                    'currentUser'        => $currentUser,
                    'form'               => $form->createView(),
                    'fileName'           => $file_name,
                    'config'             => $config,
                    'errors_array'       => $errors_array,
                    'nb_lines'           => $nb_lines,
                ));
            }
        }

        return $this->render('CRMToolsBundle:FileIntegration:fileUpload.html.twig', array(
            'displayFilesImport' => $displayFilesImport,
            'currentUser'        => $currentUser,
            'form'               => $form->createView(),
            'current_user_id'    => $user_id,


        ));
    }

    public function deleteFileAction($file_id, $file_name){

        $upload_path_dir = $this->container->getParameter('CRMToolsBundle.uploaded_files_directory');
        $upload_path_dir = $_SERVER['DOCUMENT_ROOT']. $upload_path_dir;

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('CRMToolsBundle:CrmImportFile')->deleteOneFile($file_id);

        if($file_name){
            unlink($upload_path_dir.$file_name);
        }

        return $this->redirect($this->generateUrl('crm_file_upload'));
    }

    public function businessViewAction(Request $request){

        $end_date = new \DateTime();
        $start_date = new \DateTime();
        $start_date->modify('-7 day');

        $start_date_display = $start_date->format('d-m-Y');
        $end_date_display = $end_date->format('d-m-Y');

        $date_array = $this->get('check_file_class')->generate_days($start_date, $end_date);
        $file_name_pattern = NULL;

        /*Creat the form*/
        $cliDataImports = new CLI_DATA_IMPORTS();
        $form = $this->createForm (CLI_DATA_IMPORTSType::class, $cliDataImports);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            $start_date  = $form->get("startDate")->getData();
            $end_date = $form->get("endDate")->getData();

            if (($start_date && $end_date) && $start_date > $end_date){
                return $this->redirect($this->generateUrl('crm_business_view'));
            }

            if($start_date && $end_date== NULL ){
                $end_date = $end_date = new \DateTime();
            }else if($end_date && $start_date== NULL){
                $start_date = new \DateTime();
                $start_date->modify('-7 day');
            }else if ($start_date == NULL && $end_date == NULL){
                $end_date = new \DateTime();
                $start_date = new \DateTime();
                $start_date->modify('-7 day');
            }

            $file_name_pattern = $form->get("find")->getData();
            if($file_name_pattern){
                $file_name_pattern = " and upper(FILE_NAME) LIKE upper('%$file_name_pattern%')";
            }

            $date_array = $this->get('check_file_class')->generate_days($start_date, $end_date);
        }

        try{
            rsort($date_array);

            if ($file_name_pattern)
            {
                $em = $this->getDoctrine()->getManager('oracle_prod');
                $processed_files_array= $em->getRepository('CRMToolsBundle:CLI_DATA_IMPORTS')->getProcessedFilesData($date_array, $file_name_pattern);
            }else{
                $em = $this->getDoctrine()->getManager('oracle_prod');
                $processed_files_array= $em->getRepository('CRMToolsBundle:CLI_DATA_IMPORTS')->getProcessedFilesData($date_array);
            }

        }catch (Exception $e){
            echo $e->getMessage();
        }

        return $this->render('CRMToolsBundle:FileIntegration:businessView.html.twig', array(
            'form'                             => $form->createView(),
            'date_array'                       => $date_array,
            'start_date_display'               => $start_date_display,
            'end_date_display'                 => $end_date_display,
            'processed_files_array'            => $processed_files_array
        ));
    }
}



