<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrmImportFile
 *
 * @ORM\Table(name="crm_import_file")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CrmImportFileRepository")
 */
class CrmImportFile
{

    /**
     * @ORM\ManyToOne(targetEntity="CRM\ToolsBundle\Entity\CrmUsers")
     * @ORM\JoinColumn(name="user_id",  nullable=false)
     */
    private $crmUsers;

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
     * @var int
     *
     * @ORM\Column(name="nbrLine", type="integer")
     */
    private $nbrLine;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="importDate", type="date")
     */
    private $importDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="processDate", type="date")
     */
    private $processDate;

    /**
     * @var string
     *
     * @ORM\Column(name="fileType", type="string", length=255)
     */
    private $fileType;


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
     * @return CrmImportFile
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
     * Set nbrLine
     *
     * @param integer $nbrLine
     * @return CrmImportFile
     */
    public function setNbrLine($nbrLine)
    {
        $this->nbrLine = $nbrLine;

        return $this;
    }

    /**
     * Get nbrLine
     *
     * @return integer 
     */
    public function getNbrLine()
    {
        return $this->nbrLine;
    }

    /**
     * Set importDate
     *
     * @param \DateTime $importDate
     * @return CrmImportFile
     */
    public function setImportDate($importDate)
    {
        $this->importDate = $importDate;

        return $this;
    }

    /**
     * Get importDate
     *
     * @return \DateTime 
     */
    public function getImportDate()
    {
        return $this->importDate;
    }

    /**
     * Set processDate
     *
     * @param \DateTime $processDate
     * @return CrmImportFile
     */
    public function setProcessDate($processDate)
    {
        $this->processDate = $processDate;

        return $this;
    }

    /**
     * Get processDate
     *
     * @return \DateTime 
     */
    public function getProcessDate()
    {
        return $this->processDate;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     * @return CrmImportFile
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set crmUsers
     *
     * @param \CRM\ToolsBundle\Entity\CrmUsers $crmUsers
     * @return CrmImportFile
     */
    public function setCrmUsers(\CRM\ToolsBundle\Entity\CrmUsers $crmUsers = null)
    {
        $this->crmUsers = $crmUsers;

        return $this;
    }

    /**
     * Get crmUsers
     *
     * @return \CRM\ToolsBundle\Entity\CrmUsers 
     */
    public function getCrmUsers()
    {
        return $this->crmUsers;
    }
}
