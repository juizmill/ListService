<?php

namespace Application\Controller;

use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;

/**
 * Class AbstractController
 *
 * @package Application\Controller
 * @method object|Request getRequest()
 * @SuppressWarnings(PHPMD)
 */
abstract class AbstractController extends AbstractActionController
{
    private $em;
    public $itensPerPage = 20;
    public $controller;
    public $entity;
    public $route;
    public $form;

    /**
     * __construct
     *
     * This method sets the configuration attributes: itensPerPage, controller, entity, route e form
     */
    abstract public function __construct();

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 0);

        $repository = $this->getEm()->getRepository($this->entity);
        $selectTable = new Selectable($repository);
        $criteria = new Criteria(null, ['id' => 'DESC'], null, null);

        $paginator = new Paginator($selectTable, $criteria);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage($this->itensPerPage);

        return new ViewModel(['data' => $paginator]);
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function newAction()
    {
        /**
         * @var $form \Zend\Form\Form
         */
        $form = $this->getServiceLocator()->get('FormElementManager')->get($this->form);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost()->toArray());
        }

        if ($this->getRequest()->isPost() && $form->isValid()) {
            $entity = new $this->entity;
            $hydrator = $form->getHydrator();
            $hydrator->hydrate($form->getData(), $entity);
            $this->getEm()->persist($entity);
            $this->getEm()->flush();
            $translate = $this->getServiceLocator()->get('viewhelpermanager')->get('translate');
            $this->flashMessenger()->addSuccessMessage($translate('Successfully registered!'));

            return $this->redirect()->toRoute($this->route, ['controller' => $this->controller, 'action' => 'index']);
        }

        return new ViewModel(array('form' => $form));
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $translate = $this->getServiceLocator()->get('viewhelpermanager')->get('translate');
        $entity = $this->getEm()->getRepository($this->entity)->find($this->params()->fromRoute('id'));

        if (!$entity) {
            $this->flashMessenger()->addErrorMessage($translate('Record not found'));

            return $this->redirect()->toRoute($this->route, ['controller' => $this->controller, 'action' => 'index']);
        }

        /**
         * @var $form \Zend\Form\Form
         */
        $form = $this->getServiceLocator()->get('FormElementManager')->get($this->form);
        $form->setData($entity->toArray());

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost()->toArray());
        }

        if ($this->getRequest()->isPost() && $form->isValid()) {
            $hydrator = $form->getHydrator();
            $hydrator->hydrate($form->getData(), $entity);
            $this->getEm()->persist($entity);
            $this->getEm()->flush();
            $this->flashMessenger()->addSuccessMessage($translate('Updated successfully!'));

            return $this->redirect()->toRoute($this->route, [
                "controller" => $this->controller,
                'action' => 'edit',
                'id' => $this->params()->fromRoute('id')
            ]);
        }

        return new ViewModel(array('form' => $form, 'id' => $this->params()->fromRoute('id')));
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\JsonModel
     */
    public function deleteAction()
    {
        $translate = $this->getServiceLocator()->get('viewhelpermanager')->get('translate');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $entity = $this->getEm()->getRepository($this->entity)->find($this->params()->fromRoute('id'));
            if ($entity) {
                $this->getEm()->remove($entity);
                $this->getEm()->flush();

                return new JsonModel(array(true));
            }

            return new JsonModel(array(false));
        }
        $this->flashMessenger()->addInfoMessage($translate('Operation denied'));

        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }
}
