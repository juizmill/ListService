<?php

namespace Application\Entity;

use ZfcUserDoctrineORM\Entity\User as ZfcUser;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class User
 * @package Application\Entity
 */
class User extends ZfcUser
{
    private $display_name;
    private $created_at;
    private $updated_at;
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
     * get display_name
     *
     * @return string return display name
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * set display_name
     *
     * @param string $display_name Return display name
     * @return $this
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
        return $this;
    }

    /**
     * set created_at
     *
     * @return datetime date created
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * set created_at
     *
     * @param datetime $created_at Date created
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * get updated_at
     *
     * @return datetime date updated
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * set updated
     *
     * @param datetime $updated_at Date updated
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
