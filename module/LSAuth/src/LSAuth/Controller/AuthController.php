<?php


namespace LSAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use LSAuth\Form\LoginForm;

class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $form = new LoginForm();
        $error = false;

        $request = $this->getRequest();

        if ($request->isPost()) {



            $form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $request->getPost()->toArray();

                $auth = new AuthenticationService;

                $sessionStorage = new SessionStorage("LS");
                $auth->setStorage($sessionStorage);

                $authAdapter = $this->getServiceLocator()->get('LSAuth\Auth\Adapter');

                $authAdapter->setLogin($data['login'])->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $identity = $auth->getIdentity();
                    $sessionStorage->write($identity['user'], null);
                    return $this->redirect()->toRoute("ticket", array('controller' => 'ticket'));

                }else{

                    $error = true;
                }

            }
        }

        return $viewModel->setVariables(array('form' => $form, 'error' => $error));

    }

    public function logoutAction() {

        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage('LS'));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('auth');
    }
}
