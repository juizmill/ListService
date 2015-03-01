<?php

namespace Application\Listeners\Traits;

use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

/**
 * Trait ZfcUserTrait
 *
 * @package Application\Listeners\Traits
 */
trait ZfcUserTrait
{
    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function zfcUser(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $viewModel = $event->getResult();

        if (($viewModel instanceof ViewModel) &&
            ($routeMatch->getParam('action') == 'login') ||
            ($routeMatch->getParam('action') == 'register')
        ) {
            $viewModel->setTerminal(true);
        }

        $serviceManager = $event->getApplication()->getServiceManager();
        $placeholder = $serviceManager->get('viewhelpermanager')->get('placeholder');
        $placeholder->getContainer('contentHeader')->set('<h1>User<small>Control panel</small></h1>');
    }
}
