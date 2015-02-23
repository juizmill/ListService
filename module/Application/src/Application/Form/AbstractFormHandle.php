<?php

namespace Application\Form;

use Application\Entity\Interfaces\EntityInterface;
use Application\Form\Interfaces\FormHandleInterface;
use Application\Model\Interfaces\ModelInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\FormInterface;
use Zend\Http\Request;

/**
 * Class AbstractFormHandle
 *
 * @package Application\Form
 */
class AbstractFormHandle implements FormHandleInterface
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
     * {@inheritdoc}
     */
    public function handle(Request $request, $identity = null)
    {
        if ($request->isPost()) {
            $this->getForm()->setData($request->getPost()->toArray());
        }

        if ($request->isPost() and $this->getForm()->isValid()) {
            $hydrator = $this->getForm()->getHydrator();
            $hydrator->hydrate($this->getForm()->getData(), $this->getEntity());

            if (!is_null($identity)) {
                $this->getEntity()->setIdentity($identity);
            }

            return $this->getModel()->save($this->getEntity());
        }

        return $this->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;

        return $this;
    }
}
