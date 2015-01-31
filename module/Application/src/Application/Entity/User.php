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
        return $this->displayName;
    }

    /**
     * set display_name
     *
     * @param string $displayName Return display name
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * set created_at
     *
     * @return datetime date created
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * set created_at
     *
     * @param datetime $createdAt Date created
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * get updated_at
     *
     * @return datetime date updated
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * set updated
     *
     * @param datetime $updatedAt Date updated
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
