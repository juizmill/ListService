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
        $form = $this->getServiceLocator()->get($this->form);

        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);

        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($param);

        if( $entity ) {

            $data = $entity->toArray();

            //Faz com que o nome do selected fique correto.
            $data['categoryTicket'] = $data['category_ticket']->getId();
            unset($data['category_ticket']);


            $form->setData($data);

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