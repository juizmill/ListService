<?php

namespace LSBase\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Archive
 *
 * @ORM\Table(name="archive")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSBase\Entity\Repository\ArchiveRepository")
 */
class Archive
{

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="path_file", type="string", length=50, nullable=false)
   */
  private $pathFile;

  /**
   * @var \Interaction
   *
   * @ORM\ManyToOne(targetEntity="LSInteraction\Entity\Interaction")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="intereaction_id", referencedColumnName="id")
   * })
   */
  private $intereaction;

  /**
   * __construct
   * 
   * @param array $options
   */
  public function __construct(array $options = array())
  {
    $hydrator = new Hydrator\ClassMethods;
    $hydrator->hydrate($options, $this);
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
   * Set pathFile
   *
   * @param string $pathFile
   * @return Archive
   */
  public function setPathFile($pathFile)
  {
    $this->pathFile = $pathFile;

    return $this;
  }

  /**
   * Get pathFile
   *
   * @return string 
   */
  public function getPathFile()
  {
    return $this->pathFile;
  }

  /**
   * Set intereaction
   *
   * @param \LSInteraction\Entity\Interaction $intereaction
   * @return Archive
   */
  public function setIntereaction(\LSInteraction\Entity\Interaction $intereaction = null)
  {
    $this->intereaction = $intereaction;

    return $this;
  }

  /**
   * Get intereaction
   *
   * @return \LSInteraction\Entity\Interaction 
   */
  public function getIntereaction()
  {
    return $this->intereaction;
  }

  /**
   * toArray
   * 
   * @return array
   */
  public function toArray()
  {
    $hydrator = new Hydrator\ClassMethods;
    return $hydrator->extract($this);
  }

}
