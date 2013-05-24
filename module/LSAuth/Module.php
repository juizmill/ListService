<?php

namespace LSAuth;

use Zend\ModuleManager\ModuleManager,
    Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use LSAuth\LSHelpers\UserIdentity as Identity;

use LSAuth\Auth\Adapter as AuthAdapter;

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
            )
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach("LS", 'dispatch', function($e) {
            $auth = new AuthenticationService;

            $auth->setStorage(new SessionStorage("LS"));

            $controller = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();

            if ( ! $auth->hasIdentity() and ($matchedRoute == 'user') ) {
                return $controller->redirect()->toRoute('auth');
            }
        }, 99);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'LSAuth\Auth\Adapter' => function($service) {
                    return new AuthAdapter($service->get('Doctrine\ORM\EntityManager'));
                },
                )
            );
    }

    public function getViewHelperConfig()
    {
        return array(
                'invokables' => array(
                        'UserIdentity' => new Identity()
                )
        );
    }

}
