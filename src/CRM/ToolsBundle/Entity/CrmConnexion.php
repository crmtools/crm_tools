<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmConnexion
 *
 * @ORM\Table(name="crm_connexion")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmConnexionRepository")
 */
class CrmConnexion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bddName", type="string", length=255)
     */
    private $bddName;

    /**
     * @var string
     *
     * @ORM\Column(name="environment", type="string", length=255)
     */
    private $environment;

    /**
     * @var string
     *
     * @ORM\Column(name="connectionString", type="string", length=255)
     */
    private $connectionString;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="passWord", type="string", length=255)
     */
    private $passWord;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bddName
     *
     * @param string $bddName
     * @return CrmConnexion
     */
    public function setBddName($bddName)
    {
        $this->bddName = $bddName;

        return $this;
    }

    /**
     * Get bddName
     *
     * @return string 
     */
    public function getBddName()
    {
        return $this->bddName;
    }

    /**
     * Set connectionString
     *
     * @param string $connectionString
     * @return CrmConnexion
     */
    public function setConnectionString($connectionString)
    {
        $this->connectionString = $connectionString;

        return $this;
    }

    /**
     * Get connectionString
     *
     * @return string 
     */
    public function getConnectionString()
    {
        return $this->connectionString;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return CrmConnexion
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set passWord
     *
     * @param string $passWord
     * @return CrmConnexion
     */
    public function setPassWord($passWord)
    {
        $this->passWord = $passWord;

        return $this;
    }

    /**
     * Get passWord
     *
     * @return string 
     */
    public function getPassWord()
    {
        return $this->passWord;
    }

    /**
     * Set environment
     *
     * @param string $environment
     * @return CrmConnexion
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return string 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
