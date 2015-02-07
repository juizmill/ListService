<?php

namespace Application\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Priority
 * @package Application\Entity
 * @ORM\Table(name="priority")
 * @ORM\Entity
 * @Form\Name("priority")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Priority extends AbstractEntity
{
    /**
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Description:"})
     * @var $description string
     */
    private $description;
}
