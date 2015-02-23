<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 *
 * @package Application
 * @SuppressWarnings(PHPMD)
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /**
         * @var $sharedEvents \Zend\EventManager\SharedEventManager
         */
        $sharedEvents = $eventManager->getSharedManager();

        //edit template login
        $sharedEvents->attach(
            'ZfcUser\Controller\UserController',
            MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $event) {

                $routeMatch = $event->getRouteMatch();
                $viewModel = $event->getResult();

                if (($viewModel instanceof \Zend\View\Model\ViewModel) &&
                    ($routeMatch->getParam('action') == 'login') ||
                    ($routeMatch->getParam('action') == 'register')
                ) {
                    $viewModel->setTerminal(true);
                }

                $sm = $event->getApplication()->getServiceManager();
                $translate = $sm->get('viewhelpermanager')->get('translate');
                $placeholder = $sm->get('viewhelpermanager')->get('placeholder');
                $placeholder->getContainer('contentHeader')->set(
                    '<h1>'.$translate('User').'<small>'.$translate('Control panel').'</small></h1>'
                );
            },
            -99
        );

        //Add content header in pages.
        $sharedEvents->attach('Application\Controller\CategoryController', 'dispatch', function ($e) {
            $sm = $e->getApplication()->getServiceManager();
            $translate = $sm->get('viewhelpermanager')->get('translate');
            $placeholder = $sm->get('viewhelpermanager')->get('placeholder');
            $placeholder->getContainer('contentHeader')->set(
                '<h1>'.$translate('Category').'<small>'.$translate('Content category').'</small></h1>'
            );
        }, 99);
    }

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

    public function getViewHelperConfig()
    {
        return array(
           'invokables' => array(
               'contentHeader' => 'Application\Helpers\ContentHeader',
           ),
        );
    }
}
