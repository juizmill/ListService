<?php

namespace Application\Entity\Traits;

/**
 * Class DescriptionTraint
 *
 * @package Application\Entity\Traits
 */
trait DescriptionTraint
{
    /**
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Form\Required(true)
     * @Form\Validator({"name":"NotEmpty"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StripTags"})
     * @Form\Validator({"name":"StringLength"})
     * @Form\Attributes({"type":"text", "class":"form-control"})
     * @Form\Options({"label":"Description:"})
     * @var $description string
     */
    protected $description;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
