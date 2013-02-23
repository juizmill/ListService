<?php

namespace LSUser\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
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

            $array['TypeUse'] = $array['type_use']->getId();

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

                    $this->HandlesImage($entity, true);


                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                }
            }
        } else {
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }

        return new ViewModel(array('form' => $form, 'id' => $param));
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

            $data['TypeUse'] = $data['type_use']->getId();

            unset($data['type_use']);

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

    /**
     * categoryTicketAction
     *
     * Exibe pagina para definir o tipo de usuario
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function categoryTicketAction()
    {

        $param = $this->params()->fromRoute('id', 0);
        $list = $this->getEm()->getRepository('LSCategoryticket\Entity\CategoryTicket')->findAll();

        if ($list){

            $categoryTicket = $this->getEm()->getRepository('LSBase\Entity\UserCategoryTicket')->findBy(array('user' => $param));

            return new ViewModel(array('data' => $list, 'user' => $param, 'categoryTicket' => $categoryTicket));
        }else{
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
    }


    /**
     * registreCategoryTicketAction
     *
     * Registra o usuário em determinada categoria de ticket
     *
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \Zend\View\Model\ViewModel
     */
    public function registreCategoryTicketAction()
    {

        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->isXmlHttpRequest()) {

                $service = $this->getServiceLocator()->get('LSBase\Service\CategoryTicketUser');

                $data = $service->insertAndUpdate($this->getRequest()->getPost()->toArray());

                if (! $data)
                    return $this->getResponse()->setContent(Json::encode(array('erro' => 'Não foi possivel alterar.')));

            }
        }

        exit();
    }



























    /**
     * HandlesImage
     *
     * Manipula a imagen avatar.
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @param Object $entity
     */
    protected function HandlesImage($entity, $option = false)
    {

        if ($_FILES['image']['name']) {

            if ($option)
                $this->delTree('img_user'.DIRECTORY_SEPARATOR.$entity->getId());

            if ($entity) {

                $dir = new HandlesDirectory('img_user', $entity->getId());
                $dir->createOrigin()->createIdentity();

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