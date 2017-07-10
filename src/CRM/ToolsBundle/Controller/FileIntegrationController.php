<?php

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class FileIntegrationController extends Controller
{
    public function fileUploadAction(){

        return $this->render('CRMToolsBundle:FileIntegration:fileUpload.html.twig');
    }
}
