<?php

namespace Application\Form;

use Application\Entity\Interfaces\EntityInterface;
use Application\Model\Interfaces\ModelInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element\Button;

/**
 * Class Interaction
 *
 * @package Application\Form
 */
class Interaction extends AbstractFormHandle
{
    public function __construct(AnnotationBuilder $builder, EntityInterface $entity, ModelInterface $model)
    {
        parent::__construct($builder, $entity, $model);
        $button = new Button('save');
        $button->setLabel('save')
            ->setAttributes(array(
                'class' => 'btn btn-primary',
                'type'  => 'submit',
            ));
        $this->getForm()->add($button);
    }
}
