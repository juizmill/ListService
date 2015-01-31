<?php

namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class Priority
 * @package Application\Entity
 */
class Priority
{
    private $id;
    private $description;
    private $active = true;

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
     * @return string Return a long text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * set description
     *
     * @param string $description Return a long text
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
     * @param boolean $active Return a boolean
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
