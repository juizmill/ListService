<?php

namespace Application\Controller;

use Application\Form\RecoveryPassword;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class UserController
 *
 * @package Application\Controller
 */
class UserController extends AbstractActionController
{
    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function recoveryPasswordAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $form = new RecoveryPassword();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                /**
                 * @var $entityManager \Doctrine\ORM\EntityManager
                 * @var $user \Application\Entity\User
                 */
                $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $user = $entityManager->getRepository('Application\Entity\User')->findOneBy(array(
                    'email' => $data['email']
                ));

                if (! $user) {
                    $this->flashMessenger()->addErrorMessage('E-mail not found');
                    return $this->redirect()->toUrl('/user/recovery-password');
                }

                $this->getEventManager()->trigger('sendEmail.pre', $this, ['data' => $user->toArray()]);

                $this->flashMessenger()->addSuccessMessage('Confirme you e-mail');
                return $this->redirect()->toUrl('/user/recovery-password');
            }
        }
        return $viewModel->setVariables(['form' => $form]);
    }
}
