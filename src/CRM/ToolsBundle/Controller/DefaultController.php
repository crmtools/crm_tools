<?php

namespace CRM\ToolsBundle\Controller;


use CRM\ToolsBundle\Entity\LogsView;
use CRM\ToolsBundle\Form\LogsViewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;
use Symfony\Component\Security\Core\User;
use Symfony\Component\Ldap\LdapClient;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CRMToolsBundle:Default:index.html.twig');
    }



    public function ldapConnectAction(){
        
        $ldaprdn  = 'PVCP\zkissarli';     // DN ou RDN LDAP
        $ldappass = '123Soleil';  // Mot de passe associé

// Connexion au serveur LDAP
        $ldapconn = ldap_connect("172.18.0.50")
        or die("Impossible de se connecter au serveur LDAP.");

        if ($ldapconn) {

            // Connexion au serveur LDAP
            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            // Vérification de l'authentification
            if ($ldapbind) {
                echo "Connexion LDAP réussie...";
            } else {
                echo "Connexion LDAP échouée...";
            }

            return $this->render('CRMToolsBundle:Default:login.html.twig');

        }




    }
}


