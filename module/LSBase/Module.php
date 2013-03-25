<?php

namespace LSBase;

use LSBase\View\Helpers\TotalMyTicket;
use LSBase\View\Helpers\TotalMyTicketResolved;
use LSBase\View\Helpers\TotalMyTicketOngoing;
use LSAcl\Permissions\Acl;

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

    public function getServiceConfig ()
    {
        return array(
            'factories' => array(
                'LSBase\Service\Archive' => function($em) {
                    return new Service\Archive($em->get ('Doctrine\ORM\EntityManager'));
                },
                'LSBase\Service\CategoryTicketUser' => function($em) {
                        return new Service\CategoryTicketUser($em->get ('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                    'TotalMyTicket' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicket(1);

                        return new TotalMyTicket($service);
                    },
                    'TotalMyTicketResolved' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicketResolved(1);

                        return new TotalMyTicketResolved($service);
                    },
                    'TotalMyTicketOngoing' => function($sm){
                        $service = $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('LSTicket\Entity\Ticket')->TotalMyTicketOngoing(1);

                        return new TotalMyTicketOngoing($service);
                    }
                ));
    }

}
