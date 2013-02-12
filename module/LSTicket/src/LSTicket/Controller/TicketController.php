<?php

namespace LSTicket\Controller;

use LSBase\Controller\CrudController;
use Zend\View\Model\ViewModel;


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
        $user = $this->getEm()->getReference('LSUser\Entity\User', 1);//REMOVER DEPOIS QUE CRIAR O AUTENTICATION

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

}