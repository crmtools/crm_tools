<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmGraphs
 *
 * @ORM\Table(name="crm_graphs")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmGraphsRepository")
 */
class CrmGraphs
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
     * @ORM\Column(name="graphName", type="string", length=255, unique=true)
     */
    private $graphName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enableDisplay", type="boolean")
     */
    private $enableDisplay;

    /**
     * @var int
     *
     * @ORM\Column(name="averageGraphDuration", type="integer", nullable=true)
     */
    private $averageGraphDuration;


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
     * Set graphName
     *
     * @param string $graphName
     * @return CrmGraphs
     */
    public function setGraphName($graphName)
    {
        $this->graphName = $graphName;

        return $this;
    }

    /**
     * Get graphName
     *
     * @return string 
     */
    public function getGraphName()
    {
        return $this->graphName;
    }

    /**
     * Set enableDisplay
     *
     * @param boolean $enableDisplay
     * @return CrmGraphs
     */
    public function setEnableDisplay($enableDisplay)
    {
        $this->enableDisplay = $enableDisplay;

        return $this;
    }

    /**
     * Get enableDisplay
     *
     * @return boolean 
     */
    public function getEnableDisplay()
    {
        return $this->enableDisplay;
    }

    /**
     * Set averageGraphDuration
     *
     * @param integer $averageGraphDuration
     * @return CrmGraphs
     */
    public function setAverageGraphDuration($averageGraphDuration)
    {
        $this->averageGraphDuration = $averageGraphDuration;

        return $this;
    }

    /**
     * Get averageGraphDuration
     *
     * @return integer 
     */
    public function getAverageGraphDuration()
    {
        return $this->averageGraphDuration;
    }
}
