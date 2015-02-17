<?php

namespace Application\Form\Interfaces;

use Application\Entity\Interfaces\EntityInterface;
use Zend\Form\FormInterface;
use Zend\Http\Request;
use Application\Model\Interfaces\ModelInterface;

/**
 * Class FormHandleInterface
 *
 * @package Application\Form
 */
interface FormHandleInterface
{
    /**
     * @param \Zend\Http\Request $request
     * @param null               $identity
     * @return \Application\Entity\Interfaces\EntityInterface|\Zend\Form\FormInterface
     */
    public function handle(Request $request, $identity = null);

    /**
     * @return \Application\Model\Interfaces\ModelInterface
     */
    public function getModel();

    /**
     * @param \Application\Model\Interfaces\ModelInterface $model
     * @return $this
     */
    public function setModel(ModelInterface $model);

    /**
     * @return \Zend\Form\FormInterface
     */
    public function getForm();

    /**
     * @param \Zend\Form\FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form);

    /**
     * @return \Application\Entity\Interfaces\EntityInterface
     */
    public function getEntity();

    /**
     * @param \Application\Entity\Interfaces\EntityInterface $entity
     * @return $this
     */
    public function setEntity(EntityInterface $entity);
}
