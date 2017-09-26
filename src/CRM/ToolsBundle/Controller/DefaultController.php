<?php

namespace CRM\ToolsBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;
use Symfony\Component\Security\Core\User;
use Symfony\Component\Ldap\LdapClient;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Session\Session;
use CRM\ToolsBundle\Entity\CrmUsers;
use CRM\ToolsBundle\Form\CrmUsersType;



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMToolsBundle:Default:index.html.twig');
    }

    public function ldapConnectAction(Request $request){

        /*Creat the form*/
        $crmUsers = new CrmUsers();
        $form = $this->createForm (new CrmUsersType(), $crmUsers);
        $error_msg= NULL;

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $username = $form->get("username")->getData();
            $userPvCp = 'PVCP\\' . $username;
            $password = $form->get("password")->getData();


            $ldap_host = $this->container->getParameter('CRMToolsBundle.host_ldap_serveur');
            $LdapClient = new LdapClient($ldap_host);
            $LdapClient->bind($userPvCp, $password);

//            var_dump($LdapClient);die;

            $filter = "(samaccountname=$username)";
            $dataUser = $LdapClient->find('dc=pvcp,dc=intra', $filter);

//            var_dump($request);die;
            $user=
            $user= $this->getUser()->setAttribute($username, $dataUser);

            ar_dump($user);die;


            $session = $this->get('request')->getSession();
            $session->set('ldap', $request);

            $SessioName= $session->getName();

            var_dump($SessioName);die;



            $user = $this->get('security.token_storage')->getToken()->getUser();

            $SessioName= $session->getName();
            var_dump($user);die;



            $ldap_connect = ldap_connect($ldap_host) or die("Impossible de se connecter au serveur LDAP.");


            try {
                $authentif = ldap_bind($ldap_connect, $username, $password);

                $LdapClient = new LdapClient($ldap_host);
                $LdapClient->bind($username, $password);


                $filter = "(samaccountname=$username)";
                $request = $LdapClient->find('dc=pvcp,dc=intra', $filter);

                var_dump($request);
                die;

                if ($authentif) {




                    return $this->redirect($this->generateUrl('crm_tools_homepage'));
                }

            } catch (\Exception $e) {
                $error_msg = 'The username or password is incorrect';

            }


        }

        return $this->render('CRMToolsBundle:Default:login.html.twig', array(
            'form'      => $form->createView(),
            'error_msg' => $error_msg
        ));















//        $session = $this->get('request')->getSession();
//        $sessioName= $session->getName();
//        var_dump($sessioName);die;
//        $id = $this->get('session')->get('id');
//
//        var_dump($session);
//
//        if ($session->has('ckcks45a6vji6k2p0j8p39n1o7') ){
//           var_dump('est');die;
//        }

//        var_dump($session)
//
//        var_dump($test);die;

//        if($request->isMethod('POST') ){
//            echo 'test';
//
//
//        }
//        return $this->render('CRMToolsBundle:Default:login.html.twig', array(
//            'form'      => $form->createView(),
//            'error_msg' => $error_msg
//        ));
//
//
    }
}


