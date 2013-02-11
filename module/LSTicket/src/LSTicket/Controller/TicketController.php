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
        $form = $this->getServiceLocator()->get($this->form);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            //\Zend\Debug\Debug::dump($_FILES);

        if ($_FILES['archive']['name']) {

            $upload = new UploadFile(new Http(), 'archives', 2);


        }

        die;











            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->service);
                $data = $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel(array('form' => $form));
    }
}