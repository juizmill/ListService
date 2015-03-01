<?php

namespace Application\Listeners;

use Zend\EventManager\EventInterface;

/**
 * Trait ContentHeaderTrait
 *
 * @package Application\Listeners
 */
trait ContentHeaderTrait
{
    /**
     * @param \Zend\EventManager\EventInterface $event
     */
    public function category(EventInterface $event)
    {
        /**
         * @var $controller \Zend\Mvc\Controller\AbstractActionController
         */
        $controller = $event->getTarget();
        $serviceManager = $controller->getServiceLocator();
        $placeholder = $serviceManager->get('viewhelpermanager')->get('placeholder');
        $placeholder->getContainer('contentHeader')->set('<h1>Category<small>Content category</small></h1>');
    }
}
