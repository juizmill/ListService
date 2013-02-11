<?php

namespace LSTicket;

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
                'LSTicket\Service\Ticket' => function($em) {
                    return new Service\Ticket ($em->get ('Doctrine\ORM\EntityManager'));
                },
                'LSTicket\Form\Ticket' => function($service) {
                    $em = $service->get ('Doctrine\ORM\EntityManager');

                    $categoryTicket = $em->getRepository ('LSCategoryticket\Entity\CategoryTicket');
                    $result = $categoryTicket->fetchPairs ();

                    return new Form\Ticket ($result);
                },
            )
        );
    }

}
