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

                    $typeUser = $em->getRepository ('LSTypeuser\Entity\TypeUser')->fetchPairs ();

                    return new Form\User ($typeUser);
                },
                'LSUser\Permissions\Acl' => function($sm)
                {
                  $em = $sm->get('Doctrine\ORM\EntityManager');

                  $repoRole = $em->getRepository("LSTypeuser\Entity\TypeUser");
                  $roles = $repoRole->fetchAllTypeUserActive();

                  $repoResource = $em->getRepository("LSCategoryticket\Entity\CategoryTicket");
                  $resources = $repoResource->fetchAllCategoryTicketActive();

                  $repoPrivilege = $em->getRepository("LSBase\Entity\UserCategoryTicket");
                  $privileges = $repoPrivilege->fetchAllUserCategoryTicket();

                  \Zend\Debug\Debug::dump($privileges);die;

                  #return new Acl($roles,$resources,$privileges);
                  return new Acl($roles,null,null);
                }

            )
        );

    }

}
