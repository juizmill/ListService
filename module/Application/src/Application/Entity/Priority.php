<?php

namespace Application\Entity;

use Application\Entity\Traits\DescriptionTraint;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Priority
 *
 * @package Application\Entity
 * @ORM\Table(name="priority")
 * @ORM\Entity
 * @Form\Name("priority")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Priority extends AbstractEntity
{
    use DescriptionTraint;
}
