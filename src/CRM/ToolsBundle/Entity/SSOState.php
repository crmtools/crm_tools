<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 07/12/2017
 * Time: 16:36
 */

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="saml_sso_state")
 */
class SSOState  extends \AerialShip\SamlSPBundle\Model\SSOState
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}