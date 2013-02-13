<?php

namespace LSBase;

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

}
