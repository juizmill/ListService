<?php

namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class AbstractEntity
 * @package Application\Entity
 * @ORM\MappedSuperclass
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
abstract class AbstractEntity
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
     * @ORM\Column(name="description", type="text", nullable=false)
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
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" = 1})
     * @var boolean
     */
    private $active = true;

    /**
     * construct
     *
     * @param array $options Receives an array
     */
    public function __construct(Array $options = [])
    {
        (new ClassMethods)->hydrate($options, $this);
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
     * @param  integer $id Return an integer
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
     * get description
     *
     * @return string Return long text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set description
     *
     * @param  string $description Return long text
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * get active
     *
     * @return boolean Return a boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * set active
     *
     * @param  boolean $active Return a boolean
     * @return $this
     */
    public function setActive($active)
    {
        if (! is_bool($active)) {
            throw new \RuntimeException(__FUNCTION__.' accept only boolean');
        }

        $this->active = (boolean) $active;

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
