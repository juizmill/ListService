<?php

namespace Application\Entity;

use Application\Entity\Traits\DescriptionTraint;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Class Category
 *
 * @package Application\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity
 * @Form\Name("category")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Category extends AbstractEntity
{
    use DescriptionTraint;
}
