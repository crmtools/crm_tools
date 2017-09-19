<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 19/09/2017
 * Time: 18:34
 */

namespace CRM\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends Controller
{
    public function loginAction(){

        return $this->render('CRMToolsBundle:Security:login.html.twig');
    }

}