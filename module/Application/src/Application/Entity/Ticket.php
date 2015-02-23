<?php

namespace Application\Entity;

use Application\Entity\Traits\ManyToOnePriorityTrait;
use Application\Entity\Traits\ManyToOneUserTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Ticket
 *
 * @package Application\Entity
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 * @Form\Name("ticket")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Ticket extends AbstractEntity
{
    use ManyToOnePriorityTrait;
    use ManyToOneUserTrait;

    /**
     * @ORM\Column(name="title", type="string", length=60, nullable=false)
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Title:"})
     * @var $title string
     */
    private $title;

    /**
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $dateStart datetime
     */
    private $dateStart;

    /**
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $dateEnd datetime
     */
    private $dateEnd;

    /**
     * @ORM\Column(name="date_estimated", type="datetime", nullable=true)
     * @Form\Exclude()
     * @var $dateEstimated datetime
     */
    private $dateEstimated;

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
        return $this->dateStart;
    }

    /**
     * @param $dateStart
     * @return $this
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param $dateEnd
     * @return $this
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEstimated()
    {
        return $this->dateEstimated;
    }

    /**
     * @param $dateEstimated
     * @return $this
     */
    public function setDateEstimated($dateEstimated)
    {
        $this->dateEstimated = $dateEstimated;

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
}
