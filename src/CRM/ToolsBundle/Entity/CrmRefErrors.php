<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmRefErrors
 *
 * @ORM\Table(name="crm_ref_errors")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmRefErrorsRepository")
 */
class CrmRefErrors
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
     * @ORM\Column(name="jobName", type="string", length=255)
     */
    private $jobName;

    /**
     * @var string
     *
     * @ORM\Column(name="errorText", type="text")
     */
    private $errorText;

    /**
     * @var string
     *
     * @ORM\Column(name="errorDescription", type="text")
     */
    private $errorDescription;


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
     * @return CrmRefErrors
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
     * Set errorText
     *
     * @param string $errorText
     * @return CrmRefErrors
     */
    public function setErrorText($errorText)
    {
        $this->errorText = $errorText;

        return $this;
    }

    /**
     * Get errorText
     *
     * @return string 
     */
    public function getErrorText()
    {
        return $this->errorText;
    }

    /**
     * Set errorDescription
     *
     * @param string $errorDescription
     * @return CrmRefErrors
     */
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;

        return $this;
    }

    /**
     * Get errorDescription
     *
     * @return string 
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }
}
