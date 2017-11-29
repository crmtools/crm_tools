<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmQueries
 *
 * @ORM\Table(name="crm_queries")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmQueriesRepository")
 */
class CrmQueries
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
     * @ORM\Column(name="queryName", type="string", length=255)
     */
    private $queryName;

    /**
     * @var string
     *
     * @ORM\Column(name="queryText", type="string", length=5000)
     */
    private $queryText;

    /**
     * @var string
     *
     * @ORM\Column(name="groupName", type="string", length=255)
     */
    private $groupName;

    /**
     * @var int
     *
     * @ORM\Column(name="enableDisplay", type="integer", nullable=true)
     */
    private $enableDisplay;

    /**
     * @var string
     *
     * @ORM\Column(name="pageName", type="string", length=255)
     */
    private $pageName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enableHistory", type="boolean")
     */
    private $enableHistory;

    /**
     * @var string
     *
     * @ORM\Column(name="connexion", type="string", length=255, nullable=true)
     */
    private $connexion;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="date")
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModify", type="date")
     */
    private $dateModify;

    /**
     * @ORM\ManyToOne(targetEntity="CRM\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_created", referencedColumnName="id",  nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="CRM\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_modified", referencedColumnName="id",  nullable=false)
     */
    private $modifiedBy;

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
     * Set queryName
     *
     * @param string $queryName
     * @return CrmQueries
     */
    public function setQueryName($queryName)
    {
        $this->queryName = $queryName;

        return $this;
    }

    /**
     * Get queryName
     *
     * @return string 
     */
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     * Set queryText
     *
     * @param string $queryText
     * @return CrmQueries
     */
    public function setQueryText($queryText)
    {
        $this->queryText = $queryText;

        return $this;
    }

    /**
     * Get queryText
     *
     * @return string 
     */
    public function getQueryText()
    {
        return $this->queryText;
    }

    /**
     * Set enableDisplay
     *
     * @param integer $enableDisplay
     * @return CrmQueries
     */
    public function setEnableDisplay($enableDisplay)
    {
        $this->enableDisplay = $enableDisplay;

        return $this;
    }

    /**
     * Get enableDisplay
     *
     * @return integer 
     */
    public function getEnableDisplay()
    {
        return $this->enableDisplay;
    }

    /**
     * Set pageName
     *
     * @param string $pageName
     * @return CrmQueries
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Get pageName
     *
     * @return string 
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Set enableHistory
     *
     * @param boolean $enableHistory
     * @return CrmQueries
     */
    public function setEnableHistory($enableHistory)
    {
        $this->enableHistory = $enableHistory;

        return $this;
    }

    /**
     * Get enableHistory
     *
     * @return boolean 
     */
    public function getEnableHistory()
    {
        return $this->enableHistory;
    }

    /**
     * Set connexion
     *
     * @param string $connexion
     * @return CrmQueries
     */
    public function setConnexion($connexion)
    {
        $this->connexion = $connexion;

        return $this;
    }

    /**
     * Get connexion
     *
     * @return string 
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     * @return CrmQueries
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CrmQueries
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return CrmQueries
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateModify
     *
     * @param \DateTime $dateModify
     * @return CrmQueries
     */
    public function setDateModify($dateModify)
    {
        $this->dateModify = $dateModify;

        return $this;
    }

    /**
     * Get dateModify
     *
     * @return \DateTime 
     */
    public function getDateModify()
    {
        return $this->dateModify;
    }

    /**
     * Set createdBy
     *
     * @param \CRM\UserBundle\Entity\User $createdBy
     * @return CrmQueries
     */
    public function setCreatedBy(\CRM\UserBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \CRM\UserBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedBy
     *
     * @param \CRM\UserBundle\Entity\User $modifiedBy
     * @return CrmQueries
     */
    public function setModifiedBy(\CRM\UserBundle\Entity\User $modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return \CRM\UserBundle\Entity\User 
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
}
