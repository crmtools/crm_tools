<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Service\getEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\CrmImportFile;
use CRM\ToolsBundle\Form\CrmImportFileType;
use CRM\ToolsBundle\Service\checkFile;

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
            $tmp_dir = $this->container->getParameter('CRMToolsBundle.uploaded_files_tmp_directory');

            $file_import = $em->getRepository('CRMToolsBundle:CrmImportFile')->getFileImport($file_name);

            $check_file_array = $this->get('check_file_class')->check_file_uploaded($tmp_file, $tmp_dir.$file_name, $file_name, $currentHostname, $file_import, $em, $user_id);
//            var_dump($check_file_array);die;
            if(isset($check_file_array['error_message'])){
                $error_message = $check_file_array['error_message'];
//                var_dump($error_message);die;

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

        $file_tmp_dir = $this->container->getParameter('CRMToolsBundle.uploaded_crm_files_tmp_directory');
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('CRMToolsBundle:CrmImportFile')->deleteOneFile($file_id);

        if($file_name){
            unlink($file_tmp_dir . $file_name);
        }

        return $this->redirect($this->generateUrl('crm_file_upload'));
    }

    public function businessViewAction(){

        return $this->render('CRMToolsBundle:FileIntegration:businessView.html.twig');
    }
}



