<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 *  LogsView
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="logs_view")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\LogsViewRepository")
 */
class LogsView {

//    private function __construct() {}


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name_root", type="string", length=255)
     */
    private $fileNameRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255)
     */
    private $fileName;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="iteration", type="integer")
     */
    private $iteration;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_client", type="integer")
     */
    private $nbrClient;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_event", type="integer")
     */
    private $nbrEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_booking", type="integer")
     */
    private $nbrBooking;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="file_date", type="date")
     */
    private $fileDate;

    /**
     * @var string
     *
     * @ORM\Column(name="graph_name", type="string", length=255)
     */
    private $graphName;

    /**
     * @var int
     *
     * @ORM\Column(name="average_duration_job", type="integer")
     */
    private $averageDurationJob;

    /**
     * @var Time
     *
     * @ORM\Column(name="duration_string", type="time")
     */
    private $durationString;

    ////////////////////////////////////////////////

    /**
     * Set id
     *
     * @param integer $id
     * @return LogsView
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set fileNameRoot
     *
     * @param string $fileNameRoot
     * @return LogsView
     */
    public function setFileNameRoot($fileNameRoot)
    {
        $this->fileNameRoot = $fileNameRoot;

        return $this;
    }

    /**
     * Get fileNameRoot
     *
     * @return string 
     */
    public function getFileNameRoot()
    {
        return $this->fileNameRoot;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return LogsView
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return LogsView
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return LogsView
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return LogsView
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set iteration
     *
     * @param integer $iteration
     * @return LogsView
     */
    public function setIteration($iteration)
    {
        $this->iteration = $iteration;

        return $this;
    }

    /**
     * Get iteration
     *
     * @return integer 
     */
    public function getIteration()
    {
        return $this->iteration;
    }

    /**
     * Set nbrClient
     *
     * @param integer $nbrClient
     * @return LogsView
     */
    public function setNbrClient($nbrClient)
    {
        $this->nbrClient = $nbrClient;

        return $this;
    }

    /**
     * Get nbrClient
     *
     * @return integer 
     */
    public function getNbrClient()
    {
        return $this->nbrClient;
    }

    /**
     * Set nbrEvent
     *
     * @param integer $nbrEvent
     * @return LogsView
     */
    public function setNbrEvent($nbrEvent)
    {
        $this->nbrEvent = $nbrEvent;

        return $this;
    }

    /**
     * Get nbrEvent
     *
     * @return integer 
     */
    public function getNbrEvent()
    {
        return $this->nbrEvent;
    }

    /**
     * Set nbrBooking
     *
     * @param integer $nbrBooking
     * @return LogsView
     */
    public function setNbrBooking($nbrBooking)
    {
        $this->nbrBooking = $nbrBooking;

        return $this;
    }

    /**
     * Get nbrBooking
     *
     * @return integer 
     */
    public function getNbrBooking()
    {
        return $this->nbrBooking;
    }

    /**
     * Set fileDate
     *
     * @param \DateTime $fileDate
     * @return LogsView
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
     * Set graphName
     *
     * @param string $graphName
     * @return LogsView
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
     * Set averageDurationJob
     *
     * @param integer $averageDurationJob
     * @return LogsView
     */
    public function setAverageDurationJob($averageDurationJob)
    {
        $this->averageDurationJob = $averageDurationJob;

        return $this;
    }

    /**
     * Get averageDurationJob
     *
     * @return integer 
     */
    public function getAverageDurationJob()
    {
        return $this->averageDurationJob;
    }

    /**
     * Set durationString
     *
     * @param \DateTime $durationString
     * @return LogsView
     */
    public function setDurationString($durationString)
    {
        $this->durationString = $durationString;

        return $this;
    }

    /**
     * Get durationString
     *
     * @return \DateTime 
     */
    public function getDurationString()
    {
        return $this->durationString;
    }
}
