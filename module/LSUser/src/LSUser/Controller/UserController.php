<?php

namespace LSUser\Controller;

use Zend\View\Model\ViewModel;
use LSBase\Controller\CrudController;
use LSBase\Utils\HandlesDirectory;
use \WideImage\WideImage;

/**
 * UserController
 *
 * Classe Controller UserController
 *
 * @package LSUser\Controller
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class UserController extends CrudController
{

    public function __construct()
    {
        $this->controller = 'user';
        $this->entity = 'LSUser\Entity\User';
        $this->form = 'LSUser\Form\User';
        $this->service = 'LSUser\Service\User';
        $this->route = 'user';
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

            if ($form->isValid()) {

                $service = $this->getServiceLocator()->get($this->service);
                $data = $service->insert($request->getPost()->toArray());

                $this->HandlesImage($data);


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

        $param = $this->params()->fromRoute('id', 0);

        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($param);

        if ($entity) {

            $array = $entity->toArray();
            $array['TypeUse'] = $array['type_use'];

            $form->setData($array);

            if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                //Caso o campo senha ou o campo confirmar senha não seja preenchidos
                //É informado para validar somente os campos nome, login e tipo de usuário
                if (! ($data['confirmation'] || $data['password']) )
                    $form->setValidationGroup('name', 'login', 'TypeUse');

                $form->setData($data);

                if ($form->isValid()) {

                    $service = $this->getServiceLocator()->get($this->service);
                    $service->update($data->toArray());

                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                }
            }
        } else {
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        return new ViewModel(array('form' => $form, 'id' => $param));
    }

    /**
     * HandlesImage
     *
     * Manipula a imagen avatar.
     *
     * @param Object $entity
     */
    protected function HandlesImage($entity)
    {

        if ($entity) {

            $dir = new HandlesDirectory('img_user', $entity->getId());
            $dir->createOrigin()->createIdentity();

            if ($_FILES['image']['name']) {

                $name = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];

                $name = \substr(\sha1(\uniqid(rand(), true)), -10) . '.jpg';

                $img = WideImage::loadFromFile($tmp);
                $avatar = $img->resize(28, 28, 'outside')->crop('50% - 14', '50% - 14', 28, 28);
                $medio = $img->resize(96, 96, 'outside')->crop('50% - 48', '50% - 48', 96, 96);

                $avatar->saveToFile($dir->getOrigin() . $dir->getIdentity() . 'a_' . $name, 100);
                $medio->saveToFile($dir->getOrigin() . $dir->getIdentity() . 'm_' . $name, 100);
            }
        }
    }

}