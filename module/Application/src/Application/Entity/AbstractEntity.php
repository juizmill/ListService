<?php

namespace Application\Entity;

use Application\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbstractEntity
 *
 * @package Application\Entity
 * @ORM\MappedSuperclass
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Form\Exclude()
     * @var $identity integer
     */
    protected $identity;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" = 1})
     * @Form\Exclude()
     * @var $isActive boolean
     */
    protected $isActive = true;

    /**
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        (new ClassMethods(false))->hydrate($options, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentity($identity)
    {
        if ((int)$identity <= 0) {
            throw new \RuntimeException(__FUNCTION__.' accept only positive integers greater than zero and');
        }

        $this->identity = $identity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive($isActive)
    {
        if (!is_bool($isActive)) {
            throw new \RuntimeException(__FUNCTION__.' accept only boolean');
        }

        $this->isActive = (boolean)$isActive;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return (new ClassMethods(false))->extract($this);
    }
}
