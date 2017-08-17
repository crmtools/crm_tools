<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmQueriesUcr
 *
 * @ORM\Table(name="crm_queries_ucr")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmQueriesUcrRepository")
 */
class CrmQueriesUcr
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
     * @ORM\Column(name="queryName", type="string", length=255, nullable=true)
     */
    private $queryName;

    /**
     * @var string
     *
     * @ORM\Column(name="queryText", type="string", length=4000, nullable=true)
     */
    private $queryText;

    /**
     * @var int
     *
     * @ORM\Column(name="enable", type="integer", nullable=true)
     */
    private $enable;

    /**
     * @var int
     *
     * @ORM\Column(name="displayOrder", type="integer", nullable=true)
     */
    private $displayOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="pageName", type="string", length=255, nullable=true)
     */
    private $pageName;


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
     * @return CrmQueriesUcr
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
     * @return CrmQueriesUcr
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
     * Set enable
     *
     * @param integer $enable
     * @return CrmQueriesUcr
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return integer 
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set displayOrder
     *
     * @param integer $displayOrder
     * @return CrmQueriesUcr
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder
     *
     * @return integer 
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set pageName
     *
     * @param string $pageName
     * @return CrmQueriesUcr
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
}
