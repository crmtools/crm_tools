<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CLI_DATA_IMPORTS
 *
 * @ORM\Table(name="c_l_i__d_a_t_a__i_m_p_o_r_t_s")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\CLI_DATA_IMPORTSRepository")
 */
class CLI_DATA_IMPORTS
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
     * @ORM\Column(name="FILE_NAME", type="string", length=255, nullable=true)
     */
    private $fILENAME;

    /**
     * @var string
     *
     * @ORM\Column(name="GAME_NAME", type="string", length=255, nullable=true)
     */
    private $gAMENAME;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_TRAITEMENT", type="date", nullable=true)
     */
    private $dATETRAITEMENT;

    /**
     * @var string
     *
     * @ORM\Column(name="ACTION", type="string", length=255, nullable=true)
     */
    private $aCTION;

    /**
     * @var string
     *
     * @ORM\Column(name="NBR_LIGNE", type="string", length=255, nullable=true)
     */
    private $nBRLIGNE;

    /**
     * @var string
     *
     * @ORM\Column(name="USER_MODIFY", type="string", length=30, nullable=true)
     */
    private $uSERMODIFY;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_CREATE", type="string", length=30, nullable=true)
     */
    private $sOURCECREATE;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_MODIFY", type="string", length=30, nullable=true)
     */
    private $sOURCEMODIFY;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_CREATE", type="date", nullable=true)
     */
    private $dATECREATE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_MODIFY", type="date", nullable=true)
     */
    private $dATEMODIFY;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_SYSTEM_CREATE", type="date", nullable=true)
     */
    private $dATESYSTEMCREATE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="USER_SYSTEM_CREATE", type="date", nullable=true)
     */
    private $uSERSYSTEMCREATE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_SYSTEM_MODIFY", type="date", nullable=true)
     */
    private $dATESYSTEMMODIFY;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="USER_SYSTEM_MODIFY", type="date")
     */
    private $uSERSYSTEMMODIFY;


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
     * Set fILENAME
     *
     * @param string $fILENAME
     * @return CLI_DATA_IMPORTS
     */
    public function setFILENAME($fILENAME)
    {
        $this->fILENAME = $fILENAME;

        return $this;
    }

    /**
     * Get fILENAME
     *
     * @return string 
     */
    public function getFILENAME()
    {
        return $this->fILENAME;
    }

    /**
     * Set gAMENAME
     *
     * @param string $gAMENAME
     * @return CLI_DATA_IMPORTS
     */
    public function setGAMENAME($gAMENAME)
    {
        $this->gAMENAME = $gAMENAME;

        return $this;
    }

    /**
     * Get gAMENAME
     *
     * @return string 
     */
    public function getGAMENAME()
    {
        return $this->gAMENAME;
    }

    /**
     * Set dATETRAITEMENT
     *
     * @param \DateTime $dATETRAITEMENT
     * @return CLI_DATA_IMPORTS
     */
    public function setDATETRAITEMENT($dATETRAITEMENT)
    {
        $this->dATETRAITEMENT = $dATETRAITEMENT;

        return $this;
    }

    /**
     * Get dATETRAITEMENT
     *
     * @return \DateTime 
     */
    public function getDATETRAITEMENT()
    {
        return $this->dATETRAITEMENT;
    }

    /**
     * Set aCTION
     *
     * @param string $aCTION
     * @return CLI_DATA_IMPORTS
     */
    public function setACTION($aCTION)
    {
        $this->aCTION = $aCTION;

        return $this;
    }

    /**
     * Get aCTION
     *
     * @return string 
     */
    public function getACTION()
    {
        return $this->aCTION;
    }

    /**
     * Set nBRLIGNE
     *
     * @param string $nBRLIGNE
     * @return CLI_DATA_IMPORTS
     */
    public function setNBRLIGNE($nBRLIGNE)
    {
        $this->nBRLIGNE = $nBRLIGNE;

        return $this;
    }

    /**
     * Get nBRLIGNE
     *
     * @return string 
     */
    public function getNBRLIGNE()
    {
        return $this->nBRLIGNE;
    }

    /**
     * Set uSERMODIFY
     *
     * @param string $uSERMODIFY
     * @return CLI_DATA_IMPORTS
     */
    public function setUSERMODIFY($uSERMODIFY)
    {
        $this->uSERMODIFY = $uSERMODIFY;

        return $this;
    }

    /**
     * Get uSERMODIFY
     *
     * @return string 
     */
    public function getUSERMODIFY()
    {
        return $this->uSERMODIFY;
    }

    /**
     * Set sOURCECREATE
     *
     * @param string $sOURCECREATE
     * @return CLI_DATA_IMPORTS
     */
    public function setSOURCECREATE($sOURCECREATE)
    {
        $this->sOURCECREATE = $sOURCECREATE;

        return $this;
    }

    /**
     * Get sOURCECREATE
     *
     * @return string 
     */
    public function getSOURCECREATE()
    {
        return $this->sOURCECREATE;
    }

    /**
     * Set sOURCEMODIFY
     *
     * @param string $sOURCEMODIFY
     * @return CLI_DATA_IMPORTS
     */
    public function setSOURCEMODIFY($sOURCEMODIFY)
    {
        $this->sOURCEMODIFY = $sOURCEMODIFY;

        return $this;
    }

    /**
     * Get sOURCEMODIFY
     *
     * @return string 
     */
    public function getSOURCEMODIFY()
    {
        return $this->sOURCEMODIFY;
    }

    /**
     * Set dATECREATE
     *
     * @param \DateTime $dATECREATE
     * @return CLI_DATA_IMPORTS
     */
    public function setDATECREATE($dATECREATE)
    {
        $this->dATECREATE = $dATECREATE;

        return $this;
    }

    /**
     * Get dATECREATE
     *
     * @return \DateTime 
     */
    public function getDATECREATE()
    {
        return $this->dATECREATE;
    }

    /**
     * Set dATEMODIFY
     *
     * @param \DateTime $dATEMODIFY
     * @return CLI_DATA_IMPORTS
     */
    public function setDATEMODIFY($dATEMODIFY)
    {
        $this->dATEMODIFY = $dATEMODIFY;

        return $this;
    }

    /**
     * Get dATEMODIFY
     *
     * @return \DateTime 
     */
    public function getDATEMODIFY()
    {
        return $this->dATEMODIFY;
    }

    /**
     * Set dATESYSTEMCREATE
     *
     * @param \DateTime $dATESYSTEMCREATE
     * @return CLI_DATA_IMPORTS
     */
    public function setDATESYSTEMCREATE($dATESYSTEMCREATE)
    {
        $this->dATESYSTEMCREATE = $dATESYSTEMCREATE;

        return $this;
    }

    /**
     * Get dATESYSTEMCREATE
     *
     * @return \DateTime 
     */
    public function getDATESYSTEMCREATE()
    {
        return $this->dATESYSTEMCREATE;
    }

    /**
     * Set uSERSYSTEMCREATE
     *
     * @param \DateTime $uSERSYSTEMCREATE
     * @return CLI_DATA_IMPORTS
     */
    public function setUSERSYSTEMCREATE($uSERSYSTEMCREATE)
    {
        $this->uSERSYSTEMCREATE = $uSERSYSTEMCREATE;

        return $this;
    }

    /**
     * Get uSERSYSTEMCREATE
     *
     * @return \DateTime 
     */
    public function getUSERSYSTEMCREATE()
    {
        return $this->uSERSYSTEMCREATE;
    }

    /**
     * Set dATESYSTEMMODIFY
     *
     * @param \DateTime $dATESYSTEMMODIFY
     * @return CLI_DATA_IMPORTS
     */
    public function setDATESYSTEMMODIFY($dATESYSTEMMODIFY)
    {
        $this->dATESYSTEMMODIFY = $dATESYSTEMMODIFY;

        return $this;
    }

    /**
     * Get dATESYSTEMMODIFY
     *
     * @return \DateTime 
     */
    public function getDATESYSTEMMODIFY()
    {
        return $this->dATESYSTEMMODIFY;
    }

    /**
     * Set uSERSYSTEMMODIFY
     *
     * @param \DateTime $uSERSYSTEMMODIFY
     * @return CLI_DATA_IMPORTS
     */
    public function setUSERSYSTEMMODIFY($uSERSYSTEMMODIFY)
    {
        $this->uSERSYSTEMMODIFY = $uSERSYSTEMMODIFY;

        return $this;
    }

    /**
     * Get uSERSYSTEMMODIFY
     *
     * @return \DateTime 
     */
    public function getUSERSYSTEMMODIFY()
    {
        return $this->uSERSYSTEMMODIFY;
    }
}
