<?php

namespace LSBase\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

/**
 * CrudController
 *
 * Classe abstrata dos Controllers
 *
 * @package LSBase\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
abstract class CrudController extends AbstractActionController
{

    protected $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;
    protected $limitPaginator = 10;

    public function getAuthService() {
        return $this->authService;
    }

    /**
     * indexAction
     *
     * Exibe pagina principal.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {

        $user = $this->getUserCurrent();

        if ( $user[0]->getId() != 1)
            $list = $this->getEm()->getRepository($this->entity)->findBy(array('user' => $user[0]->getId()));
        else
            $list = $this->getEm()->getRepository($this->entity)->findAll();

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($this->limitPaginator);

        #ACL
        $acl = $this->getServiceLocator()->get("LSUser\Permissions\Acl");
        $type = $this->getEm()->getRepository("LSUser\Entity\User")->findTypeUser($user[0]->getId());

        return new ViewModel(array('data' => $paginator, 'page' => $page, 'typeUser' => $type, 'acl' => $acl));

    }

    /**
     * newAction
     *
     * Exibe pagina de cadastro.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function newAction()
    {
        $form = new $this->form();

        $request = $this->getRequest();

        if( $request->isPost() ) {

            $form->setData($request->getPost());

            if( $form->isValid() ) {

                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel(array('form' => $form));

    }

    /**
     * editAction
     *
     * Exibe pagina para editar o registro.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        $form = new $this->form();

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);

        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($param);

        if( $entity ) {

            $form->setData($entity->toArray());

            if( $request->isPost() ) {

                $form->setData($request->getPost());

                if( $form->isValid() ) {

                    $service = $this->getServiceLocator()->get($this->service);
                    $service->update($request->getPost()->toArray());

                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                }
            }
        } else {
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        return new ViewModel(array('form' => $form, 'id' => $param));

    }

    /**
     * deleteAction
     *
     * Deleta um registo.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return redirect current controller
     */
    public function deleteAction()
    {
        $service = $this->getServiceLocator()->get($this->service);
        if( $service->delete($this->params()->fromRoute('id', 0)) )
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        else
            $this->getResponse()->setStatusCode(404);

    }

    /**
     * activeAction
     *
     * Ativa ou desativa o registro
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return redirect current controller
     */
    public function activeAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        $entity = $this->getEm()->getRepository($this->entity)->findOneBy(array('id' => $id));

        if( $entity ) {

            $data = $entity->toArray();

            if( $data['active'] == 1 )
                $data['active'] = 0;
            else
                $data['active'] = 1;

            $service = $this->getServiceLocator()->get($this->service);

            if( $service->update($data) )
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            else
                $this->getResponse()->setStatusCode(404);
        }
    }


    public function getUserCurrent()
    {
        #Recupera a autenticação do usuário
        $sessionStorage = new SessionStorage("LS");
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        #verifica se o usuário está autenticado
        if ($this->getAuthService()->hasIdentity()) {
          return $this->getAuthService()->getIdentity();
        }
    }



    /**
     * getEm
     *
     * Prepara o EntityManager
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return EntityManager
     */
    public function getEm()
    {
        if( null === $this->em )
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        return $this->em;

    }

}
