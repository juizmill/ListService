<?php

namespace Application\Entity;

use Application\Entity\Traits\DescriptionTraint;
use Application\Entity\Traits\ManyToOneUserTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\Form\Annotation as Form;

/**
 * Class Interaction
 *
 * @package Application\Entity
 * @ORM\Table(name="interaction")
 * @ORM\Entity
 * @Form\Name("interaction")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Interaction extends AbstractEntity
{
    use DescriptionTraint;
    use ManyToOneUserTrait;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_posted", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $date_posted datetime
     */
    private $datePosted;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Ticket")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="ticket", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var $ticket \Application\Entity\Ticket
     */
    private $ticket;

    /**
     * @return \DateTime
     */
    public function getDatePosted()
    {
        return $this->datePosted;
    }

    /**
     * @param $datePosted
     * @return $this
     */
    public function setDatePosted($datePosted)
    {
        $this->datePosted = $datePosted;

        return $this;
    }

    /**
     * @return \Application\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param  \Application\Entity\Ticket $ticket
     * @return $this
     */
    public function setTicket(Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }
}
