<?php

namespace Application\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Interaction
 * @package Application\Entity
 * @ORM\Table(name="interaction")
 * @ORM\Entity
 * @Form\Name("interaction")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @SuppressWarnings(PHPMD)
 */
class Interaction extends AbstractEntity
{
    /**
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Description:"})
     * @var $description string
     */
    private $description;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_posted", type="datetime", nullable=false)
     * @Form\Exclude()
     * @var \DateTime
     */
    private $date_posted;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Ticket")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="ticket", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var Ticket
     */
    private $ticket;

    /**
    * @Form\Exclude()
    * @ORM\ManyToOne(targetEntity="Application\Entity\User")
    * @ORM\JoinColumns({
    *     @ORM\JoinColumn(name="user", referencedColumnName="id")
    * })
    * @var User
    */
    private $user;

    /**
     * @return \DateTime
     */
    public function getDatePosted()
    {
        return $this->date_posted;
    }

    /**
     * @param $date_posted
     * @return $this
     */
    public function setDatePosted($date_posted)
    {
        $this->date_posted = $date_posted;

        return $this;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param Ticket $ticket
     * @return $this
     */
    public function setTicket(Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
