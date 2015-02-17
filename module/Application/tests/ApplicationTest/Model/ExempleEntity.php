<?php

namespace ApplicationTest\Model;

use Application\Entity\Interfaces\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class ExempleEntity
 *
 * @package ApplicationTest\Model
 * @ORM\Table(name="exemple")
 * @ORM\Entity
 * @Form\Name("exemple")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class ExempleEntity implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Form\Exclude()
     * @var $identity integer
     */
    private $identity;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" = 1})
     * @Form\Type("Zend\Form\Element\Checkbox")
     * @var $isActive boolean
     */
    private $isActive;

    /**
     * @return integer
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param $identity integer
     * @return $this
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param $isActive bool
     * @return $this
     */
    public function setActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array();
    }
}