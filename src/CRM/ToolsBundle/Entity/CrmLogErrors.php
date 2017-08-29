<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmLogErrors
 *
 * @ORM\Table(name="crm_log_errors")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmLogErrorsRepository")
 */
class CrmLogErrors
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
     * @ORM\Column(name="fileName", type="string", length=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="jobName", type="string", length=800, nullable=true)
     */
    private $jobName;

    /**
     * @var int
     *
     * @ORM\Column(name="errorCount", type="integer")
     */
    private $errorCount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fileDate", type="date")
     */
    private $fileDate;

    /**
     * @var string
     *
     * @ORM\Column(name="errorText", type="text")
     */
    private $errorText;

    /**
     * @ORM\ManyToOne(targetEntity="CRM\ToolsBundle\Entity\CrmRefErrors")
     * @ORM\JoinColumn(name="ref_errors_id", nullable=true)
     */
    private $crmRefErrors;


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
     * Set fileName
     *
     * @param string $fileName
     * @return CrmLogErrors
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set jobName
     *
     * @param string $jobName
     * @return CrmLogErrors
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
     * Set errorCount
     *
     * @param integer $errorCount
     * @return CrmLogErrors
     */
    public function setErrorCount($errorCount)
    {
        $this->errorCount = $errorCount;

        return $this;
    }

    /**
     * Get errorCount
     *
     * @return integer 
     */
    public function getErrorCount()
    {
        return $this->errorCount;
    }

    /**
     * Set fileDate
     *
     * @param \DateTime $fileDate
     * @return CrmLogErrors
     */
    public function setFileDate($fileDate)
    {
        $this->fileDate = $fileDate;

        return $this;
    }

    /**
     * Get fileDate
     *
     * @return \DateTime 
     */
    public function getFileDate()
    {
        return $this->fileDate;
    }

    /**
     * Set errorText
     *
     * @param string $errorText
     * @return CrmLogErrors
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
     * Set crmRefErrors
     *
     * @param \CRM\ToolsBundle\Entity\CrmRefErrors $crmRefErrors
     * @return CrmLogErrors
     */
    public function setCrmRefErrors(\CRM\ToolsBundle\Entity\CrmRefErrors $crmRefErrors = null)
    {
        $this->crmRefErrors = $crmRefErrors;

        return $this;
    }

    /**
     * Get crmRefErrors
     *
     * @return \CRM\ToolsBundle\Entity\CrmRefErrors 
     */
    public function getCrmRefErrors()
    {
        return $this->crmRefErrors;
    }
}
