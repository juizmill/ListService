<?php

namespace LSPriority\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Priority
 *
 * @ORM\Table(name="priority")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LSPriority\Entity\Repository\PriorityRepository")
 */
class Priority
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * __construct
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);

        $this->active = true;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param  string   $description
     * @return Priority
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set active
     *
     * @param  boolean  $active
     * @return Priority
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods;

        return $hydrator->extract($this);
    }

}
