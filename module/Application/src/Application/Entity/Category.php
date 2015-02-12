<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Category
 * @package Application\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity
 * @Form\Name("category")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @SuppressWarnings(PHPMD)
 */
class Category extends AbstractEntity
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
