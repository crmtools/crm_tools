<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\CrmImportFile;
use CRM\ToolsBundle\Form\CrmImportFileType;
use CRM\ToolsBundle\Service\checkFile;

class FileIntegrationController extends Controller
{
    public function fileUploadAction(Request $request)
    {
        $config = $this->container->getParameter('CRMToolsBundle.config');
        $em = $this->getDoctrine()->getManager();
        $displayFilesImport = $em->getRepository('CRMToolsBundle:CrmImportFile')->displayFilesImport();
        $currentHostname = $this->get('utility_class')->getUserHostname();

        $currentUser = $em->getRepository('CRMToolsBundle:CrmUsers')->getCurrentUser($currentHostname);

        /*Creat the date form*/
        $crmImportFile = new crmImportFile();
        $form = $this->createForm(new CrmImportFileType(), $crmImportFile);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $data = $form->getData();
            $file_name = $data->getFileName()->getClientOriginalName();
            $tmp_file = $data->getFileName()->getPathName();
            $tmp_dir = $this->container->getParameter('CRMToolsBundle.uploaded_files_tmp_directory');

            $em = $this->getDoctrine()->getManager();
            $file_import = $em->getRepository('CRMToolsBundle:CrmImportFile')->getFileImport($file_name);

            move_uploaded_file($tmp_file, $tmp_dir . $file_name);
            $value_return = $this->get('check_file_class')->check_file_uploaded($config, $tmp_dir . $file_name, $file_name, $currentHostname, $file_import);

        }
        return $this->render('CRMToolsBundle:FileIntegration:fileUpload.html.twig', array(
            'displayFilesImport' => $displayFilesImport,
            'currentUser' => $currentUser,
            'form' => $form->createView(),
        ));
    }
}



