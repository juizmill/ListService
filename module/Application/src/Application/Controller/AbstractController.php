<?php

namespace Application\Controller;

use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;

abstract class AbstractController extends AbstractActionController
{
    const ENTITY_NAMESPACE= 'add_entity_namespace';
    const ROUTE_NAME = 'add_route_name';
    const CONTROLLER_NAME = 'add_controller_name';
    const FORM_NAMESPACE = 'add_form_namespace';
    const ITEM_PER_PAGE = 20;

    private $em;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 0);

        $repository = $this->getEm()->getRepository(self::ENTITY_NAMESPACE);
        $selectTable = new Selectable($repository);
        $criteria = new Criteria(null, ['id' => 'DESC'], null, null);

        $paginator = new Paginator($selectTable, $criteria);

        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(self::ITEM_PER_PAGE);

        return new ViewModel(['data' => $paginator]);
    }

    public function newAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
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
