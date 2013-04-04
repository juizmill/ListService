<?php

namespace LSTicket\Controller;

use LSBase\Controller\CrudController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

use LSBase\Utils\UploadFile;

use Zend\File\Transfer\Adapter\Http;


/**
 * TicketController
 *
 * Classe Controller TicketController
 *
 * @package LSTicket\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TicketController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'ticket';
    $this->entity = 'LSTicket\Entity\Ticket';
    $this->form = 'LSTicket\Form\Ticket';
    $this->service = 'LSTicket\Service\Ticket';
    $this->route = 'ticket';
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
        $list = $this->getEm()->getRepository($this->entity)->findAllTicket($user[0]['id']);

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                ->setDefaultItemCountPerPage($this->limitPaginator);

        return new ViewModel(array('data' => $paginator, 'page' => $page));

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

        $form = $this->getServiceLocator()->get($this->form);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                //Registra o User
                $data = $this->getRequest()->getPost()->toArray();

                //Registra o ticket
                $service = $this->getServiceLocator()->get($this->service);
                $ticket = $service->insert($data);

                //Registra a Interação
                if ($ticket){

                    $user = $this->getUserCurrent();
                    $entityUser = $this->getEm()->getRepository('LSUser\Entity\User')->find($user[0]["id"]);

                    $service2 = $this->getServiceLocator()->get('LSInteraction\Service\Interaction');
                    $interaction = $service2->insert(array(
                                    'description' => $data['description'],
                                    'ticket' => $ticket,
                                    'user' => $entityUser));
                }

                //Registra o arquivo
                if ($_FILES['archive']['name'] && $interaction){

                    $upload = new UploadFile(new Http(), 'archives', $ticket->getId(), $interaction->getId());

                    //Registra o Arquivo
                    $service3 = $this->getServiceLocator()->get('LSBase\Service\Archive');
                    $archive = $service3->insert(array(
                                                'pathFile' => $upload->getFileName(),
                                                'interaction' => $interaction));
                }


                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel(array('form' => $form));
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

      $param = $this->params()->fromRoute('id', 0);

        $service = $this->getServiceLocator()->get($this->service);
        $delete = $service->delete($param);

        if($delete){

            $this->delTree('archives'.DIRECTORY_SEPARATOR.$param);

            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }else{
            $this->getResponse()->setStatusCode(404);
        }

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

            if( $service->updateActive($data) )
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            else
                $this->getResponse()->setStatusCode(404);
        }
    }


    public function dateEstimatedAction()
    {

        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->isXmlHttpRequest()) {

                $data = $this->getRequest()->getPost()->toArray();

                $service = $this->getServiceLocator()->get($this->service);
                if ($service->update($data))
                    \Zend\Debug\Debug::dump("OK");die;
            }
        }

        exit();

    }

    /**
     * categoryTicketAction
     *
     * Exibe pagina para definir o tipo de usuario
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function agenteAction()
    {

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $param = $this->params()->fromRoute('id', 0);
        $list = $this->getEm()->getRepository('LSUser\Entity\User')->findAll();

        $ticket = $this->getEm()->getRepository($this->entity)->find(array('id' => $param));

        if ($list){

            if ($ticket->getUser())
                return $viewModel->setVariables(array('data' => $list, 'id' => $param, 'user' => $ticket->getUser()->getId()));
            else
                return $viewModel->setVariables(array('data' => $list, 'id' => $param));
        }else{
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
    }

    /**
     * registreAgenteAction
     *
     * Registra o usuário em determinada categoria de ticket
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function registreAgenteAction()
    {

        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->isXmlHttpRequest()) {

                $service = $this->getServiceLocator()->get('LSTicket\Service\Ticket');

                $data = $service->updateUser($this->getRequest()->getPost()->toArray());

                if (! $data)
                    return $this->getResponse()->setContent(Json::encode(array('erro' => 'Não foi possivel alterar.')));

            }
        }

        exit();
    }

    /**
     * delTree
     *
     * Deleta arquivos e subpastas.
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @param  String $dir
     */
    public static function delTree($dir)
    {
        $files = glob($dir . '*' , GLOB_MARK);
        foreach ($files as $file) {
            if (substr($file, -1) == '/')
                self::delTree($file);
            else
                unlink($file);
        }

        if (is_dir($dir))
            rmdir($dir);
    }

}