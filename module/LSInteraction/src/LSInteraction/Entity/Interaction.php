<?php

namespace LSInteraction\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Interaction
 *
 * @ORM\Table(name="interaction")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSInteraction\Entity\Repository\IntegrationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Interaction
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
   * @var \DateTime
   *
   * @ORM\Column(name="date_posted", type="datetime", nullable=false)
   */
  private $datePosted;

  /**
   * @var string
   *
   * @ORM\Column(name="description", type="text", nullable=false)
   */
  private $description;

  /**
   * @var \Ticket
   *
   * @ORM\ManyToOne(targetEntity="LSTicket\Entity\Ticket")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
   * })
   */
  private $ticket;

  /**
   * @var \User
   *
   * @ORM\ManyToOne(targetEntity="LSUser\Entity\User")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   * })
   */
  private $user;

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
   * Set datePosted
   *
   * @ORM\PrePersist
   * @param \DateTime $datePosted
   * @return Interaction
   */
  public function setDatePosted()
  {
    $this->datePosted = new \DateTime('now');

    return $this;
  }

  /**
   * Get datePosted
   *
   * @return \DateTime
   */
  public function getDatePosted()
  {
    return $this->datePosted;
  }

  /**
   * Set description
   *
   * @param string $description
   * @return Interaction
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get description
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set ticket
   *
   * @param \LSTicket\Entity\Ticket $ticket
   * @return Interaction
   */
  public function setTicket(\LSTicket\Entity\Ticket $ticket = null)
  {
    $this->ticket = $ticket;

    return $this;
  }

  /**
   * Get ticket
   *
   * @return \LSTicket\Entity\Ticket
   */
  public function getTicket()
  {
    return $this->ticket;
  }

  /**
   * Set user
   *
   * @param \LSUser\Entity\User $user
   * @return Interaction
   */
  public function setUser(\LSUser\Entity\User $user = null)
  {
    $this->user = $user;

    return $this;
  }

  /**
   * Get user
   *
   * @return \LSUser\Entity\User
   */
  public function getUser()
  {
    return $this->user;
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
