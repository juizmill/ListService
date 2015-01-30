<?php

namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

class Category
{
    private $id;
    private $description;
    private $active;

    public function __construct(Array $options = [])
    {
        (new ClassMethods)->hydrate($options, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}
