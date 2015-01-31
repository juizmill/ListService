<?php

namespace Application\Entity;

use DateTime;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class Interaction
 * @package Application\Entity
 */
class Interaction
{
    private $id;
    private $date_posted;
    private $description;
    private $ticket;
    private $user;

    /**
     * construct
     *
     * @param array $options Receives an array
     */
    public function __construct(Array $options = [])
    {
        (new ClassMethods())->hydrate($options, $this);
    }

    /**
     * get id
     *
     * @return integer Return an integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set id
     *
     * @param integer $id Return an integer
     * @return $this;
     */
    public function setId($id)
    {
        $id = (int) $id;

        if ($id <= 0) {
            throw new \RuntimeException(__FUNCTION__.' accept only positive integers greater than zero and');
        }

        $this->id = $id;
        return $this;
    }

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
     * get description
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set description
     *
     * @param string $description Return long text
     * @return $this;
     */
    public function setDescription($description)
    {
        $this->description = $description;
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

    /**
     * to array
     *
     * @return array Return array list
     */
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }


}