<?php

namespace Application\Controller;

use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;

/**
 * Class AbstractController
 * @package Application\Controller
 */
abstract class AbstractController extends AbstractActionController
{
    private $em;
    protected $itensPerPage = 20;
    protected $controller;
    protected $entity;
    protected $route;
    protected $form;

    /**
     * __construct
     *
     * This method sets the configuration attributes: itensPerPage, controller, entity, route e form
     */
    abstract public function __construct();

    /**
     * index action
     *
     * @return \Zend\View\Model\ViewModel Return an view model
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
     * new action
     *
     * @return \Zend\View\Model\ViewModel Return an view model
     */
    public function newAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get($this->form);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost()->toArray());

            if ($form->isValid()) {
                $entity = new $this->entity;
                $hydrator = $form->getHydrator();
                $hydrator->hydrate($form->getData(), $entity);
                $this->getEm()->persist($entity);
                $this->getEm()->flush();
                $this->flashMessenger()->addSuccessMessage('Successfully registered!');
                return $this->redirect()->toRoute($this->route, ['controller' => $this->controller, 'action' => 'index']);
            }
        }
        return new ViewModel(array('form' => $form));
    }

    /**
     * edit action
     *
     * @return \Zend\View\Model\ViewModel Return an view model
     */
    public function editAction()
    {
        $entity = $this->getEm()->getRepository($this->entity)->find($this->params()->fromRoute('id'));

        if ($entity) {
            $form = $this->getServiceLocator()->get('FormElementManager')->get($this->form);
            $form->setData($entity->getArrayCopy());

            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost()->toArray());

                if ($form->isValid()) {
                    $hydrator = $form->getHydrator();
                    $hydrator->hydrate($form->getData(), $entity);
                    $this->getEm()->persist($entity);
                    $this->getEm()->flush();
                    $this->flashMessenger()->addSuccessMessage('Updated successfully!');
                    return $this->redirect()->toRoute($this->route, ['controller' => $this->controller, 'action' => 'edite', 'id' => $this->params()->fromRoute('id')]);
                }
            }

            return new ViewModel(array('form' => $form, 'id' => $this->params()->fromRoute('id')));
        }
        $this->flashMessenger()->addErrorMessage('Record not found');
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
    }

    /**
     * delete action
     *
     * @return \Zend\View\Model\JsonModel Return an Json
     */
    public function deleteAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $entity = $this->getEm()->getRepository($this->entity)->find($this->params()->fromRoute('id'));
            if ($entity) {
                $this->getEm()->remove($entity);
                $this->getEm()->flush();

                return new JsonModel(array(true));
            }

            return new JsonModel(array(false));
        }
        $this->flashMessenger()->addInfoMessage('Operation denied');
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
    }

    /**
     * get em
     *
     * @return \Doctrine\ORM\EntityManager Return Entity Manager
     */
    public function getEm()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }
}
