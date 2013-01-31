<?php

namespace LSUser;

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
                'LSUser\Service\USer' => function($em) {
                    return new Service\User ($em->get ('Doctrine\ORM\EntityManager'));
                },
                'LSUser\Form\User' => function($service) {
                    $em = $service->get ('Doctrine\ORM\EntityManager');

                    $typeUser = $em->getRepository ('LSTypeuser\Entity\TypeUser');
                    $result = $typeUser->fetchPairs ();

                    return new Form\User ($result);
                },
            )
        );

    }

}
