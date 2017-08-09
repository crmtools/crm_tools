<?php

namespace CRM\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassUcr
 *
 * @ORM\Table(name="Class_ucr")
 * @ORM\Entity(repositoryClass="CRM\ToolsBundle\Repository\ClassUcrRepository")
 */
class ClassUcr
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


}
