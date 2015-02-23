<?php

namespace Application\Entity\Traits;

use Application\Entity\Priority;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class ManyToOnePriorityTrait
 *
 * @ORM\Entity
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @package Application\Entity\Traits
 */
trait ManyToOnePriorityTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Priority")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="priority", referencedColumnName="id")
     * })
     * @Form\Exclude()
     * @var $priority Priority
     */
    private $priority;

    /**
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param  Priority $priority
     * @return $this
     */
    public function setPriority(Priority $priority)
    {
        $this->priority = $priority;

        return $this;
    }
}
