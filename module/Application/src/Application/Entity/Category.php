<?php

namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class Category
 * @package Application\Entity
 */
class Category
{
    private $id;
    private $description;
    private $active;

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
     * @param integer $id Return an integer
     * @return $this;
     */
    public function setId($id)
    {
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
     * @param string $description Return long text
     * @return $this;
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
     * @param boolean $active Return a boolean
     * @return $this;
     */
    public function setActive($active)
    {
        $this->active = $active;
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
