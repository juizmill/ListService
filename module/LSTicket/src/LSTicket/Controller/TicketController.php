<?php

namespace LSTicket\Controller;

use LSBase\Controller\CrudController;
use Zend\View\Model\ViewModel;


use LSBase\Utils\UploadFile;

use Zend\File\Transfer\Adapter\Http;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;



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

        $sessionStorage = new SessionStorage("LS");
        $authService = new AuthenticationService;
        $authService->setStorage($sessionStorage);

        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity();

            $userId = $this->getEm()->getReference('LSUser\Entity\User', $user[0]['id']);

            $list = $this->getEm()->getRepository($this->entity)->findBy(array('user' => $userId->getId()));

            $page = $this->params()->fromRoute('page');


\Zend\Debug\Debug::dump($list[0]);die;


            $paginator = new Paginator(new ArrayAdapter($list[0]));
            $paginator->setCurrentPageNumber($page)
                      ->setDefaultItemCountPerPage($this->limitPaginator);

            return new ViewModel(array('data' => $paginator, 'page' => $page));

        }

$a = "
SELECT t.id, ct.description as category, p.description as priority, t.title, t.date_begin, t.date_end, t.date_estimated, t.sought
FROM listservice.ticket t
JOIN listservice.category_ticket ct ON (t.category_ticket_id = ct.id )
Left JOIN listservice.priority p ON (t.priority_id = p.id )
WHERE t.active = true AND ct.active = true AND t.user_id = 2
;
";





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
        $idUser = $this->getUserCurrent();
        $user = $this->getEm()->getReference('LSUser\Entity\User', $idUser[0]->getId());

        $form = $this->getServiceLocator()->get($this->form);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                //Registra o User
                $data = $this->getRequest()->getPost()->toArray();
                $data['user'] = $user;

                //Registra o ticket
                $service = $this->getServiceLocator()->get($this->service);
                $ticket = $service->insert($data);

                //Registra a Interação
                if ($ticket){
                    $service2 = $this->getServiceLocator()->get('LSInteraction\Service\Interaction');
                    $interaction = $service2->insert(array(
                                                'description' => $data['description'],
                                                'ticket' => $ticket,
                                                'user' => $user));
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