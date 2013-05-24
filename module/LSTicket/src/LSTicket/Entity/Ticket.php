<?php

namespace LSTicket\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSTicket\Entity\Repository\TicketRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Ticket
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
   * @ORM\Column(name="title", type="string", length=60, nullable=false)
   */
  private $title;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date_begin", type="datetime", nullable=false)
   */
  private $dateBegin;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date_end", type="datetime", nullable=true)
   */
  private $dateEnd;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date_estimated", type="datetime", nullable=true)
   */
  private $dateEstimated;

  /**
   * @var string
   *
   * @ORM\Column(name="sought", type="string", length=45, nullable=false)
   */
  private $sought;

  /**
   * @var boolean
   *
   * @ORM\Column(name="active", type="boolean", nullable=false)
   */
  private $active;

  /**
   * @var \CategoryTicket
   *
   * @ORM\ManyToOne(targetEntity="LSCategoryticket\Entity\CategoryTicket")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="category_ticket_id", referencedColumnName="id")
   * })
   */
  private $categoryTicket;

  /**
   * @var \Priority
   *
   * @ORM\ManyToOne(targetEntity="LSPriority\Entity\Priority")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
   * })
   */
  private $priority;

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
    $this->active = true;
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
   * Set title
   *
   * @param string $title
   * @return Ticket
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set dateBegin
   *
   * @ORM\PrePersist
   * @param \DateTime $dateBegin
   * @return Ticket
   */
  public function setDateBegin()
  {
    $this->dateBegin = new \DateTime('now');

    return $this;
  }

  /**
   * Get dateBegin
   *
   * @return \DateTime
   */
  public function getDateBegin()
  {
    return $this->dateBegin;
  }

  /**
   * Set dateEnd
   *
   * @param \DateTime $dateEnd
   * @return Ticket
   */
  public function setDateEnd($dateEnd)
  {
    $this->dateEnd = $dateEnd;

    return $this;
  }

  /**
   * Get dateEnd
   *
   * @return \DateTime
   */
  public function getDateEnd()
  {
    return $this->dateEnd;
  }

  /**
   * Set dateEstimated
   *
   * @param \DateTime $dateEstimated
   * @return Ticket
   */
  public function setDateEstimated($dateEstimated)
  {
    $this->dateEstimated = $dateEstimated;

    return $this;
  }

  /**
   * Get dateEstimated
   *
   * @return \DateTime
   */
  public function getDateEstimated()
  {
    return $this->dateEstimated;
  }

  /**
   * Set sought
   *
   * @param string $sought
   * @return Ticket
   */
  public function setSought($sought)
  {
    $this->sought = $sought;

    return $this;
  }

  /**
   * Get sought
   *
   * @return string
   */
  public function getSought()
  {
    return $this->sought;
  }

  /**
   * Set active
   *
   * @param boolean $active
   * @return Ticket
   */
  public function setActive($active)
  {
    $this->active = $active;

    return $this;
  }

  /**
   * Get active
   *
   * @return boolean
   */
  public function getActive()
  {
    return $this->active;
  }

  /**
   * Set categoryTicket
   *
   * @param \LSCategoryticket\Entity\CategoryTicket $categoryTicket
   * @return Ticket
   */
  public function setCategoryTicket(\LSCategoryticket\Entity\CategoryTicket $categoryTicket = null)
  {
    $this->categoryTicket = $categoryTicket;

    return $this;
  }

  /**
   * Get categoryTicket
   *
   * @return \LSCategoryticket\Entity\CategoryTicket
   */
  public function getCategoryTicket()
  {
    return $this->categoryTicket;
  }

  /**
   * Set priority
   *
   * @param \LSPriority\Entity\Priority $priority
   * @return Ticket
   */
  public function setPriority(\LSPriority\Entity\Priority $priority = null)
  {
    $this->priority = $priority;

    return $this;
  }

  /**
   * Get priority
   *
   * @return \LSPriority\Entity\Priority
   */
  public function getPriority()
  {
    return $this->priority;
  }

  /**
   * Set user
   *
   * @param \LSUser\Entity\User $user
   * @return Ticket
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
