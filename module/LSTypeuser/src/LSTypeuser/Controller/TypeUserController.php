<?php

namespace LSTypeuser\Controller;

use Zend\View\Model\ViewModel;
use LSBase\Controller\CrudController;

/**
 * TypeUserController
 *
 * Classe Controller TypeUserController
 *
 * @package LSTypeuser\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class TypeUserController extends CrudController
{

    public function __construct ()
    {
        $this->controller = 'type-user';
        $this->entity = 'LSTypeuser\Entity\TypeUser';
        $this->form = 'LSTypeuser\Form\TypeUser';
        $this->service = 'LSTypeuser\Service\TypeUser';
        $this->route = 'type-user';

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
    public function newAction ()
    {

        $form = new $this->form();

        $request = $this->getRequest ();

        if ( $request->isPost () ) {

            $form->setData ($request->getPost ());

            $data = $request->getPost ()->toArray ();

            $duplicate = $this->getEm ()->getRepository ($this->entity)->findOneBy (array('description' => $data['description']));

            if ( $duplicate ) {
                return new ViewModel (array('form' => $form, 'duplicate' => 'Já existe um cadastrado com este nome!'));
            }

            if ( $form->isValid () ) {

                $service = $this->getServiceLocator ()->get ($this->service);
                $service->insert ($data);

                return $this->redirect ()->toRoute ($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel (array('form' => $form));

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
    public function editAction ()
    {
        $form = new $this->form();

        $request = $this->getRequest ();
        $param = $this->params ()->fromRoute ('id', 0);

        $repository = $this->getEm ()->getRepository ($this->entity);
        $entity = $repository->find ($param);

        if ( $entity ) {

            $form->setData ($entity->toArray ());

            if ( $request->isPost () ) {

                $form->setData ($request->getPost ());

                $data = $request->getPost ()->toArray ();

                $duplicate = $this->getEm ()->getRepository ($this->entity)->findOneBy (array('description' => $data['description']));

                if ( $duplicate ) {
                    return new ViewModel (array('form' => $form, 'id' => $param, 'duplicate' => 'Já existe um cadastrado com este nome!'));
                }
                if ( $form->isValid () ) {

                    $service = $this->getServiceLocator ()->get ($this->service);
                    $service->update ($data);

                    return $this->redirect ()->toRoute ($this->route, array('controller' => $this->controller));
                }
            }
        } else {
            return $this->redirect ()->toRoute ($this->route, array('controller' => $this->controller));
        }

        return new ViewModel (array('form' => $form, 'id' => $param));

    }

}