<?php

namespace Application\Form;

use Application\Entity\Interfaces\EntityInterface;
use Application\Model\Interfaces\ModelInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\FormInterface;
use Zend\Http\Request;

/**
 * Class AbstractFormHandle
 *
 * @package Application\Form
 */
class AbstractFormHandle
{
    protected $model;
    protected $form;
    protected $entity;

    /**
     * @param \Zend\Form\Annotation\AnnotationBuilder        $builder
     * @param \Application\Entity\Interfaces\EntityInterface $entity
     * @param \Application\Model\Interfaces\ModelInterface   $model
     */
    public function __construct(AnnotationBuilder $builder, EntityInterface $entity, ModelInterface $model)
    {
        $form = $builder->createForm($entity);
        $this->setModel($model);
        $this->setForm($form);
        $this->setEntity($entity);
    }

    /**
     * @param \Zend\Http\Request $request
     * @return \Application\Entity\Interfaces\EntityInterface|\Zend\Form\FormInterface
     */
    public function handle(Request $request)
    {
        if ($request->isPost()) {
            $this->getForm()->setData($request->getPost()->toArray());
        }

        if ($request->isPost() and $this->getForm()->isValid()) {
            $hydrator = $this->getForm()->getHydrator();
            $hydrator->hydrate($this->getForm()->getData(), $this->getEntity());

            return $this->getModel()->save($this->getEntity());
        }

        return $this->getForm();
    }

    /**
     * @return \Application\Model\Interfaces\ModelInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \Application\Model\Interfaces\ModelInterface $model
     * @return $this
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return \Zend\Form\FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param \Zend\Form\FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @return \Application\Entity\Interfaces\EntityInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param \Application\Entity\Interfaces\EntityInterface $entity
     * @return $this
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;
        return $this;
    }
}
