<?php

namespace Application\Controller;

use Application\Form\Interfaces\FormHandleInterface;
use Application\Model\Interfaces\ModelInterface;
use Doctrine\Common\Collections\Criteria;
use Zend\Paginator\Paginator;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

/**
 * Class AbstractController
 *
 * @package Application\Controller
 */
class AbstractController extends AbstractActionController
{
    protected $model;
    protected $form;
    protected $route;
    protected $controller;
    protected $itemPerPage;

    /**
     * @param ModelInterface $model
     * @param FormHandleInterface  $form
     * @param string         $route
     * @param string         $controller
     * @param int            $itemPerPage
     */
    public function __construct(
        ModelInterface $model,
        FormHandleInterface $form,
        $route,
        $controller,
        $itemPerPage = 25
    ) {
        $this->model = $model;
        $this->form = $form;
        $this->route = $route;
        $this->controller = $controller;
        $this->itemPerPage = $itemPerPage;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 0);

        $repository = $this->model->getRepository();
        $criteria = new Criteria(null, ['identity' => 'DESC'], null, null);
        $selectTableAdapter = new Selectable($repository, $criteria);

        $paginator = new Paginator($selectTableAdapter);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage($this->itemPerPage);

        return new ViewModel(['data' => $paginator]);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $handle = $this->form->handle($request);

        if (! $handle instanceof Form) {
            return $this->redirect()->toRoute($this->route, ['controller' => $this->controller, 'action' => 'index']);
        }

        return new ViewModel(['form' => $handle]);
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $handle = $this->form->handle($request);

        return new ViewModel(['form' => $handle]);
    }

    public function deleteAction()
    {

    }
}
