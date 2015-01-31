<?php

namespace Application\Entity;

use DateTime;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class Interaction
 * @package Application\Entity
 */
class Interaction extends AbstractEntity
{
    private $date_posted;
    private $ticket;
    private $user;

    /**
     * get date_posted
     *
     * @return \DateTime
     */
    public function getDatePosted()
    {
        return $this->date_posted;
    }

    /**
     * set date_posted
     *
     * @param datetime $date_posted Return datetime
     * @return $this
     */
    public function setDatePosted($date_posted)
    {
        $this->date_posted = $date_posted;
        return $this;
    }

    /**
     * get ticket
     *
     * @return \Application\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * set ticket
     *
     * @param object $ticket \Application\Entity\Ticket
     * @return $this
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }

    /**
     * get user
     *
     * @return \Application\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * set user
     *
     * @param User|object $user \Application\Entity\User
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
