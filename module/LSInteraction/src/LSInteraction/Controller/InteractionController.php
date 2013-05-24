<?php

namespace LSInteraction\Controller;

use Zend\View\Model\ViewModel;
use Zend\File\Transfer\Adapter\Http;

use LSBase\Utils\UploadFile;
use LSBase\Controller\CrudController;

/**
 * InteractionController
 *
 * Classe Controller InteractionController
 *
 * @package LSInteraction\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class InteractionController extends CrudController
{

  public function __construct()
  {
    $this->controller = 'interaction';
    $this->entity = 'LSInteraction\Entity\Interaction';
    $this->form = 'LSInteraction\Form\Interaction';
    $this->service = 'LSInteraction\Service\Interaction';
    $this->route = 'interaction';
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

        $userId = $this->getUserCurrent();

        $user = $this->getEm()->getReference('LSUser\Entity\User', $userId[0]['id']);

        $form = new $this->form();

        $param = $this->params()->fromRoute('id', 0);

        $ticket = $this->getEm()->getRepository('LSTicket\Entity\Ticket')->find($param);
        $description = $this->getEm()->getRepository('LSInteraction\Entity\Interaction')->findBy(array('ticket' => $param));
        $archive = $this->getEm()->getRepository('LSBase\Entity\Archive')->findAll();

        foreach ($archive as $value) {
            $itens[] = array('path' => $value->getPathFile(), 'interaction_id' => $value->getIntereaction()->getId());
        }

        //\Zend\Debug\Debug::dump($itens);die;

        if ($ticket) {

            if ( $this->getRequest()->isPost() ) {

                $form->setData($this->getRequest()->getPost());

                if ( $form->isValid()) {

                    $data = $this->getRequest()->getPost()->toArray();
                    $data['user'] = $user;
                    $data['ticket'] = $ticket;

                    $service = $this->getServiceLocator()->get($this->service);
                    $interaction = $service->insert($data);

                  //Registra o arquivo
                  if ($_FILES['archive']['name'] && $interaction) {

                      $upload = new UploadFile(new Http(), 'data/uploads', $ticket->getId(), $interaction->getId());

                      //Registra o Arquivo
                      $service2 = $this->getServiceLocator()->get('LSBase\Service\Archive');
                      $archive = $service2->insert(array(
                                                  'pathFile' => $upload->getFileName(),
                                                  'interaction' => $interaction));
                  }

                    return $this->redirect()->toRoute('ticket', array('controller' => 'ticket'));
                }
            }

            return new ViewModel(array('form' => $form, 'ticket' => $ticket, 'description' => $description, 'archive' => $archive));
        } else {
            return $this->redirect()->toRoute('ticket', array('controller' => 'ticket'));
        }

    }

}
