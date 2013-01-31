<?php

namespace LSCategoryticket;

class Module
{

    public function getConfig ()
    {
        return include __DIR__ . '/config/module.config.php';

    }

    public function getAutoloaderConfig ()
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
                'LSCategoryticket\Service\CategoryTicket' => function($em) {
                    return new Service\CategoryTicket ($em->get ('Doctrine\ORM\EntityManager'));
                }
            )
        );

    }

}
