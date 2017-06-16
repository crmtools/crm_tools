<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmJobs
 *
 * @ORM\Table(name="crm_jobs")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmJobsRepository")
 */
class CrmJobs
{

    /**
     * @ORM\ManyToOne(targetEntity="CRM\ToolsBundle\Entity\CrmGraphs")
     * @ORM\JoinColumn(name="graph_id", nullable=true)
     */
    private $crmGraphs;

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
     * @ORM\Column(name="jobName", type="string", length=255, nullable=true)
     */
    private $jobName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="displayOrder", type="integer")
     */
    private $displayOrder;


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
     * Set jobName
     *
     * @param string $jobName
     * @return CrmJobs
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;

        return $this;
    }

    /**
     * Get jobName
     *
     * @return string 
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return CrmJobs
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set displayOrder
     *
     * @param boolean $displayOrder
     * @return CrmJobs
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder
     *
     * @return boolean 
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set crmGraphs
     *
     * @param \CRM\ToolsBundle\Entity\CrmGraphs $crmGraphs
     * @return CrmJobs
     */
    public function setCrmGraphs(\CRM\ToolsBundle\Entity\CrmGraphs $crmGraphs = null)
    {
        $this->crmGraphs = $crmGraphs;

        return $this;
    }

    /**
     * Get crmGraphs
     *
     * @return \CRM\ToolsBundle\Entity\CrmGraphs 
     */
    public function getCrmGraphs()
    {
        return $this->crmGraphs;
    }
}
