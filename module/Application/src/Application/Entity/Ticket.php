<?php

namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Annotation as Form;

/**
 * Class Ticket
 * @package Application\Entity
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 * @Form\Name("ticket")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @SuppressWarnings(PHPMD)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Form\Exclude()
     * @var $id integer
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=60, nullable=false)
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Title:"})
     * @var $description string
     */
    private $title;

    /**
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $date_start datetime
     */
    private $date_start;

    /**
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $date_end datetime
     */
    private $date_end;

    /**
     * @ORM\Column(name="date_estimated", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $date_estimated datetime
     */
    private $date_estimated;

    /**
     * @ORM\Column(name="sought", type="string", length=45, nullable=false)
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Sought:"})
     * @var $sought string
     */
    private $sought;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false)
     * @Form\Exclude()
     * @var $active bool
     */
    private $active = true;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Priority")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="priority", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var $priority Priority
     */
    private $priority;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var $user User
     */
    private $user;

    /**
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        (new ClassMethods())->hydrate($options, $this);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        if ((int) $id <= 0) {
            throw new \RuntimeException(__FUNCTION__.' accept only positive integers greater than zero and');
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param $date_start
     * @return $this
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param $date_end
     * @return $this
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEstimated()
    {
        return $this->date_estimated;
    }

    /**
     * @param $date_estimated
     * @return $this
     */
    public function setDateEstimated($date_estimated)
    {
        $this->date_estimated = $date_estimated;

        return $this;
    }

    /**
     * @return string
     */
    public function getSought()
    {
        return $this->sought;
    }

    /**
     * @param $sought
     * @return $this
     */
    public function setSought($sought)
    {
        $this->sought = $sought;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

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
     * @param $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}
