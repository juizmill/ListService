<?php

namespace LSBase;

use LSBase\View\Helpers\TotalMyTicket;
use LSBase\View\Helpers\TotalMyTicketResolved;
use LSBase\View\Helpers\TotalMyTicketOngoing;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use LSUser\Permissions\Acl;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getAuthService()
    {
        return $this->authService;
    }

    public function getUserCurrent()
    {
        #Recupera a autenticação do usuário
        $sessionStorage = new SessionStorage("LS");
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        #verifica se o usuário está autenticado
        if ($this->getAuthService()->hasIdentity()) {
          $user = $this->getAuthService()->getIdentity();

          return $user[0]['id'];
        }
    }

    public function getServiceConfig ()
    {
        return array(
            'factories' => array(
                'LSBase\Service\Archive' => function($em) {
                    return new Service\Archive($em->get ('Doctrine\ORM\EntityManager'));
                },
                'LSBase\Service\CategoryTicketUser' => function($em) {
                        return new Service\CategoryTicketUser($em->get ('Doctrine\ORM\EntityManager'));
                },

                //esta parte do "programa" é exclusivo para realizar as permissões de cada usuário.
                'LSUser\Permissions\Acl' => function($sm) {
                  $em = $sm->get('Doctrine\ORM\EntityManager');

                  #Recupera os Papeis de usuários
                  $repoRole = $em->getRepository("LSTypeuser\Entity\TypeUser");
                  $roles = $repoRole->fetchAllTypeUserActive();

                  #Recupera os Recursos do Usuário
                  $repoResource = $em->getRepository("LSCategoryticket\Entity\CategoryTicket");
                  $resources = $repoResource->fetchAllCategoryTicketActive();

                  #Recupera os privilégios que o usuário possui
                  $repoPrivilege = $em->getRepository("LSBase\Entity\UserCategoryTicket");
                  $privileges = $repoPrivilege->fetchAllUserCategoryTicket($this->getUserCurrent());

                  return new Acl($roles,$resources,$privileges);
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                    'TotalMyTicket' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicket($this->getUserCurrent());

                        return new TotalMyTicket($service);
                    },
                    'TotalMyTicketResolved' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicketResolved($this->getUserCurrent());

                        return new TotalMyTicketResolved($service);
                    },
                    'TotalMyTicketOngoing' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicketOngoing($this->getUserCurrent());

                        return new TotalMyTicketOngoing($service);
                    }
                ));
    }

}
