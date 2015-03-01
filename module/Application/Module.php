<?php

namespace Application;

use Application\Listeners\ControllerListener;
use Zend\EventManager\EventInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

/**
 * Class Module
 *
 * @package Application
 * @SuppressWarnings(PHPMD)
 */
class Module implements BootstrapListenerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $eventManager        = $e->getTarget()->getEventManager();
        $eventManager->attachAggregate(new ControllerListener());
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
